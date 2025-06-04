<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Stock;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    //
    public function index() {
        // Fetch all sales with their related products and stores
        $sales = Sale::with(['product', 'store'])->get();

        return response()->json($sales);
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            $stock = Stock::where('product_id', $request->productId)
                         ->where('store_id', $request->storeId)
                         ->first();

            if (!$stock) {
                return response()->json([
                    'error' => 'Product not found in store inventory'
                ], 404);
            }

            if ($stock->quantity < $request->quantity) {
                return response()->json([
                    'error' => 'Insufficient stock. Available: ' . $stock->quantity,
                    'available' => $stock->quantity
                ], 400);
            }

            // Update stock quantity
            $stock->update([
                'quantity' => $stock->quantity - $request->quantity
            ]);

            Sale::create([
                'product_id' => $request->productId,
                'store_id' => $request->storeId,
                'quantity' => $request->quantity,
                'sold_at' => $request->soldAt,
            ]);

            // Commit transaction
            DB::commit();

            return response()->json([
                'success' => 'Sale recorded successfully.'], 200
            );

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            return response()->json([
                'error' => 'Failed to record sale: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Find the existing sale
            $sale = Sale::findOrFail($id);

            // Find the stock
            $stock = Stock::where('product_id', $request->product_id ?? $sale->product_id)
                         ->where('store_id', $request->store_id ?? $sale->store_id)
                         ->first();

            if (!$stock) {
                return response()->json([
                    'error' => 'Product not found in store inventory'
                ], 404);
            }

            // Calculate the difference in quantity
            $quantityDifference = ($request->quantity ?? $sale->quantity) - $sale->quantity;

            // Check if there's sufficient stock for the update
            if ($stock->quantity < $quantityDifference) {
                return response()->json([
                    'error' => 'Insufficient stock. Available: ' . $stock->quantity,
                    'available' => $stock->quantity
                ], 400);
            }

            // Update stock quantity
            $stock->update([
                'quantity' => $stock->quantity - $quantityDifference
            ]);

            // Update the sale
            $sale->update([
                'product_id' => $request->productId ?? $sale->product_id,
                'store_id' => $request->storeId ?? $sale->store_id,
                'quantity' => $request->quantity ?? $sale->quantity,
                'sold_at' => $request->sold_at ?? $sale->sold_at,
            ]);

            // Commit transaction
            DB::commit();

            return response()->json([
                'success' => 'Sale updated successfully.'], 200);

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            return response()->json([
                'error' => 'Failed to update sale: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id) {
        try {
            $sale = Sale::findOrFail($id);
            $stock = Stock::where('product_id', $sale->product_id)
                         ->where('store_id', $sale->store_id)
                         ->first();

            if ($stock) {
                // Restore stock quantity
                $stock->update([
                    'quantity' => $stock->quantity + $sale->quantity
                ]);
            }

            $sale->delete();

            return response()->json(['success' => 'Sale deleted successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete sale: ' . $e->getMessage()], 500);
        }
    }
}
