<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Resources\ProductResource;
use App\Services\FileHandler;

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
            'external_link' => $request->extLink
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

        $product = Product::create([
            'project_id' => $product->project_id,
            'title' => $product->title.' - Copy',
            'description' => $product->description,
            'category' => $product->category,
            'images' => $product->images,
            'pricing' => $product->pricing,
            'shipping' => $product->shipping,
            'inventory' => $product->inventory,
            'files' => $product->files,
            'external_link' => $product->external_link
        ]);

        return response([
            'message' => 'Product duplicated.',
            'productId' => $product->id,
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
            if(str_contains($file, 'base64')) {
                $relativePath = $this->saveFile('product-files', $file);
                array_push($newFileList, $relativePath);
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
            'external_link' => $request->extLink
        ]);

        // product info in category data treat
        $categories = json_decode($request->category);
        // if(count($categories) > 0) {
            foreach($categories as $cat) {
                $prodCat = ProductCategory::where('project_id', $product->project_id)
                    ->where('title', $cat)
                    ->first();

                // If request category does not exist add new
                if(!$prodCat) {
                    $prodCatArr = [['id' => $product->id, 'name' => $product->title]];

                    ProductCategory::create([
                        'title' => $cat,
                        'slug' => $cat,
                        'products' => json_encode($prodCatArr),
                        'project_id' => $product->project_id
                    ]);
                }elseif($prodCat) {
                    // check if product exist in arr else add
                    $prodCatArr = json_decode($prodCat->products);

                    if(count($prodCatArr) > 0) {
                        $counter = 0;

                        foreach($prodCatArr as $prod) {
                            if($prod->id == $product->id) {
                                $counter += 1;
                            }
                        }

                        if($counter == 0) {
                            array_push($prodCatArr, (object)[
                                'id' => $product->id,
                                'name' => $product->title
                            ]);
                        }
                    }

                    // $existingProductInCat = json_decode($prodCat->products);
                    // $existingCatInProduct = json_decode($request->category);
                    
                    $prodCat->update([
                        'products' => json_encode($prodCatArr)
                    ]);
                }
            }

            $prodCategories = ProductCategory::where('project_id', $product->project_id)->get();

            foreach ($prodCategories as $prodCatKeys => $prodCat) {
                foreach ($categories as $catKey => $cat) {
                    if($cat != $prodCat) {
                        $categoryProd = json_decode($prodCat->products);
                        // if(count($categoryProd)>0) {
                            foreach($categoryProd as $prodKey => $prod) {
                                if ($product->id == $prod->id) {
                                    unset($categoryProd[$prodKey]);
                                    $prodCat->update(['products' => json_encode($prodCat->products)]);
                                }
                            }
                        // }
                    }
                }
            }
            
        // }

        return response([
            'message' => 'Product Updated.',
            'data' => new ProductResource($product)
        ]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // delete biolink if associated 
        // delete product id from category

        $product->delete();

        return response([
            'message' => 'Product deleted.',
            'status_code' => 204
        ]);
    }
}
