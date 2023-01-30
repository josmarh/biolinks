<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Resources\ProductResource;
use App\Services\FileHandler;
use Log;

class ProductController extends Controller
{
    use FileHandler;

    public function index(Request $request, $projectId)
    {
        $productTitle = $request->query('title');

        if(isset($productTitle)) {
            $products = Product::where('project_id', $projectId)
                ->where('title', 'like', '%'.$productTitle.'%')
                ->orderBy('id', 'desc')
                ->paginate(15);
        }else {
            $products = Product::where('project_id', $projectId)
                ->orderBy('id', 'desc')
                ->paginate(15);
        }

        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'project_id' => $request->projectId,
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'images' => $request->images,
            'pricing' => $request->pricing,
            'shipping' => $request->shipping,
            'inventory' => $request->inventory,
            'files' => $request->prodFiles,
            'external_link' => $request->extLink,
            'published_status' => 'Unpublished'
        ]);

        return response([
            'message' => 'Product created.',
            'productId' => $product->id,
            'status_code' => 201
        ], 201);
    }

    public function duplicate($id)
    {
        $product = Product::findOrFail($id);

        $newProduct = Product::create([
            'project_id' => $product->project_id,
            'title' => $product->title.' - Copy',
            'description' => $product->description,
            'category' => $product->category,
            'images' => $product->images,
            'pricing' => $product->pricing,
            'shipping' => $product->shipping,
            'inventory' => $product->inventory,
            'files' => $product->files,
            'external_link' => $product->external_link,
            'published_status' => $product->published_status
        ]);

        // check if product has category and insert into it

        return response([
            'message' => 'Product duplicated.',
            'productId' => $newProduct->id,
            'status_code' => 201
        ], 201);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return new ProductResource($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string'
        ]);

        // Check for images and files
        $images = json_decode($request->images);
        $files = json_decode($request->prodFiles);
        $newImgList = [];
        $newFileList = [];

        foreach($images as $img) {
            if(str_contains($img, 'base64')) {
                $relativePath = $this->saveFile('product-images', $img);
                array_push($newImgList, $relativePath);
            }else {
                array_push($newImgList, $img);
            }
        }

        foreach($files as $file) {
            if(str_contains($file->file, 'base64')) {
                $relativePath = $this->saveFile('product-files', $file->file);
                array_push($newFileList, (object)[
                    'name' => $file->name, 
                    'file' => $relativePath,
                    'type' => $file->type,
                ]);
            }else {
                array_push($newFileList, $file);
            }
        }

        // delete images and files from dir not needed

        $product->update([
            'link_id' => $request->linkId,
            'title' => $data['title'],
            'description' => $request->description,
            'category' => $request->category,
            'images' => json_encode($newImgList),
            'pricing' => $request->pricing,
            'shipping' => $request->shipping,
            'inventory' => $request->inventory,
            'files' => json_encode($newFileList),
            'external_link' => $request->extLink,
            'published_status' => $request->publishedStatus
        ]);

        // Add or update category
        $categories = json_decode($request->category);

        if(count($categories) > 0) {
            $notInProductCategories = [];
            $projectCategories = ProductCategory::where('project_id', $product->project_id)->get();

            foreach($categories as $cat) {
                // Check if category exist
                $category = ProductCategory::where('project_id', $product->project_id)
                    ->where('title', $cat)
                    ->first();

                // If request category does not exist add new
                if(!$category) {
                    $newCategoryProduct = [['id' => $product->id, 'name' => $product->title]];

                    ProductCategory::create([
                        'title' => $cat,
                        'slug' => $cat,
                        'products' => json_encode($newCategoryProduct),
                        'project_id' => $product->project_id
                    ]);
                } // update category products where category exist
                elseif($category) {
                    // check if product exist in category->products else add
                    $categoryProducts = json_decode($category->products);

                    if(count($categoryProducts) > 0) {
                        $counter = 0;
                        foreach($categoryProducts as $categoryProduct) {
                            if($categoryProduct->id == $product->id) {
                                $counter += 1;
                            }
                        }
                        if($counter == 0) {
                            array_push($categoryProducts, (object)[
                                'id' => $product->id,
                                'name' => $product->title
                            ]);
                        }
                    }else {
                        array_push($categoryProducts, (object)[
                            'id' => $product->id,
                            'name' => $product->title
                        ]);
                    }

                    $category->update([
                        'products' => json_encode($categoryProducts)
                    ]);
                }

                // remove product from category products where $this category is not (if product exist there)
                if(count($projectCategories) > 0) {
                    foreach ($projectCategories as $projectCategory) {
                        if($projectCategory->title !== $cat) {
                            array_push($notInProductCategories, $projectCategory->title);
                        }
                    }
                }
            }            

            $unique = array_values(array_unique($notInProductCategories));
            $notInProductCategories = array_diff($unique, $categories);

            if(count($notInProductCategories) > 0) {
                foreach ($projectCategories as $projectCategory) {
                    foreach ($notInProductCategories as $notInProductCategory) {
                        if($projectCategory->title == $notInProductCategory) {
                            $categoryProducts = json_decode($projectCategory->products);
                            foreach ($categoryProducts as $categoryProductKey => $categoryProduct) {
                                if($product->id == $categoryProduct->id) {
                                    unset($categoryProducts[$categoryProductKey]);
                                }
                            }
                            $projectCategory->update([
                                'products' => json_encode($categoryProducts)
                            ]);
                        }
                    }
                }
            }
        }else {
            // check all project category where product exist and remove product
            $projectCategories = ProductCategory::where('project_id', $product->project_id)->get();

            if(count($projectCategories) > 0) {
                foreach ($projectCategories as $projectCategory) {
                    $categoryProducts = json_decode($projectCategory->products);
                    foreach ($categoryProducts as $categoryProductKey => $categoryProduct) {
                        if($categoryProduct->id == $product->id) {
                            unset($categoryProducts[$categoryProductKey]);
                        }
                    }
                    // update category product after product is deleted
                    $projectCategory->update([
                        'products' => json_encode($categoryProducts)
                    ]);
                }
            }
        }

        return response([
            'message' => 'Product Updated.',
            'data' => new ProductResource($product)
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // delete biolink if associated 

        // delete product id from category products
        $projectCategories = ProductCategory::where('project_id', $product->project_id)->get();

        if(count($projectCategories) > 0) {
            foreach ($projectCategories as $projectCategory) {
                $categoryProducts = json_decode($projectCategory->products);

                foreach ($categoryProducts as $categoryProductKey => $categoryProduct) {
                    if($categoryProduct->id == $product->id) {
                        unset($categoryProducts[$categoryProductKey]);
                    }
                }
                // update category product after product is deleted
                $projectCategory->update([
                    'products' => json_encode($categoryProducts)
                ]);
            }
        }

        $product->delete();

        return response([
            'message' => 'Product deleted.',
            'status_code' => 204
        ]);
    }

}
