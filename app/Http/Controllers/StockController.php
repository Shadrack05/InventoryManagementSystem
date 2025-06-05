<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StockRequest;

class StockController extends Controller
{
    //
    public function index() {
        // Fetch all stocks with their related products and stores
        $stocks = Stock::with(['product', 'store'])->get();

        return response()->json($stocks);
    }

    public function create(StockRequest $request)
    {
        try {
            $stock = Stock::where([
                'product_id' => $request->productId,
                'store_id' => $request->storeId,
            ])->first();

            if ($stock) {
                // Update existing stock by adding quantities
                $stock->update([
                    'quantity' => $stock->quantity + $request->quantity,
                    'price' => $request->price,
                ]);
            } else {
                // Create new stock
                $stock = Stock::create([
                    'product_id' => $request->productId,
                    'store_id' => $request->storeId,
                    'quantity' => $request->quantity,
                    'price' => $request->price,
                ]);
            }

            return response()->json([
                'success' => 'Stock updated successfully'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create/update stock: ' . $e->getMessage()
            ], 500);
        }
    }
    public function update(StockRequest $request, $id) {
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
