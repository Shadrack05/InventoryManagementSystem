<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Store;
use Illuminate\Http\Request;

class StockController extends Controller
{
    //
    public function index() {
        // Fetch all stocks with their related products and stores
        $stocks = Stock::with(['product', 'store'])->get();

        return response()->json($stocks);
    }

    public function create(Request $request) {
        try {

            Stock::create([
                'product_id' => $request->productId,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'store_id' => $request->storeId,
            ]);

            return response()->json(['success' => 'Stock created successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create stock: ' . $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id) {
        try {
            $stock = Stock::findOrFail($id);

            $stock->update([
                'quantity' => $request->quantity,
                'price' => $request->price,
                'store_id' => $request->store_id,
                'product_id' => $request->product_id,
            ]);
            return response()->json(['success' => 'Stock updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update stock: ' . $e->getMessage()], 500);
        }
    }
    public function destroy($id) {
        try {
            $stock = Stock::findOrFail($id);
            $stock->delete();
            return response()->json(['success' => 'Stock deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete stock: ' . $e->getMessage()], 500);
        }
    }
}
