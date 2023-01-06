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
        $prodCategory = ProductCategory::where('project_id', $projectId)->paginate(15);

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
        $prodCategory = ProductCategory::findOrFail($id);

        
    }
}
