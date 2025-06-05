<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductsController extends Controller
{
    //f
    public function index() {
        //
        $products = Products::all();

        return response()->json($products);
    }

    public function create(ProductRequest $request) {
        try {
            Products::create([
                'name' => $request->name,
                'sku' => strtoupper($request->sku),
                'description' => $request->description,
            ]);

            return response()->json(['success' => 'Product created successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product: ' . $e->getMessage()], 500);
        }
    }

    public function update(UpdateProductRequest $request, $id) {
        try {
            $product = Products::findOrFail($id);
            $product->update([
                'name' => $request->name,
                'sku' => strtoupper($request->sku),
                'description' => $request->description,
            ]);

            return response()->json(['success' => 'Product updated successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update product: ' . $e->getMessage()], 500);
        }
    }
    public function destroy($id) {
        try {
            $product = Products::findOrFail($id);
            $product->delete();
            return response()->json(['success' => 'Product deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete product: ' . $e->getMessage()], 500);
        }
    }



}
