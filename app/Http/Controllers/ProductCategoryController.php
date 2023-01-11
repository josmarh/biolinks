<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductResource;

class ProductCategoryController extends Controller
{
    public function index($projectId)
    {
        $prodCategory = ProductCategory::where('project_id', $projectId)
            ->orderBy('id', 'desc')
            ->paginate(15);

        return ProductCategoryResource::collection($prodCategory);
    }

    public function show($id)
    {
        $prodCategory = ProductCategory::findOrFail($id);

        return new ProductCategoryResource($prodCategory);
    }

    public function update(Request $request, $id)
    {
        $prodCategory = ProductCategory::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string'
        ]);

        $prodCategory->update([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'products' => $request->products
        ]);

        return response([
            'message' => 'Category updated.',
            'data' => new ProductCategoryResource($prodCategory),
            'status_code' => 200
        ], 200);
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);

        // check all project product where category is used
        $products = Product::where('project_id', $category->project_id)->get();

        foreach ($products as $productKey => $product) {
            $productCategories = json_decode($product->category);

            if(count($productCategories) > 0) {
                foreach ($productCategories as $productCatKey => $productCategory) {
                    if($productCategory == $category->title) {
                        unset($productCategories[$productCatKey]);
                    }
                }
                // update product after category is deleted
                $product->update([
                    'category' => json_encode($productCategories)
                ]);
            }
        }
        $category->delete();

        return response([
            'message' => 'Category deleted.',
            'status_code' => 204
        ], 200);
    }

    public function search(Request $request, $projectId) 
    {
        $category = $request->query('category');
        $prodCategory = ProductCategory::where('project_id', $projectId)
            ->where('title', 'like', '%'.$category.'%')
            ->get();

        return ProductCategoryResource::collection($prodCategory);
    }
}
