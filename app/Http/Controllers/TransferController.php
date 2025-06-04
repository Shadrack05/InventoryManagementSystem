<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Store;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    //
    public function index() {
        // Fetch all transfers with their related stores and products
        $transfers = Transfer::with(['fromStore', 'toStore', 'product'])->get();

        return response()->json($transfers);
    }

    public function create(Request $request) {
        try {
            DB::beginTransaction();

            $stock = Stock::where('product_id', $request->productId)
                         ->where('store_id', $request->fromStoreId)
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

            Transfer::create([
                'product_id' => $request->productId,
                'from_store_id' => $request->fromStoreId,
                'to_store_id' => $request->toStoreId,
                'quantity' => $request->quantity,
            ]);

            $store = Store::with(['branch'])->findOrFail($request->toStoreId);
            $branchId = $store->branch->id;

            Stock::updateOrCreate(
                [
                    'product_id' => $request->productId,
                    'store_id' => $request->toStoreId,
                    'branch_id' => $branchId,
                    'price' => $stock->price
                ],
                [
                    'quantity' => DB::raw('quantity + ' . $request->quantity)
                ]
            );

            // Commit transaction
            DB::commit();

            return response()->json([
                'success' => 'Transfer recorded successfully.'], 200
            );

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            return response()->json([
                'error' => 'Failed to record sale: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            DB::beginTransaction();

            // Find the existing transfer
            $transfer = Transfer::findOrFail($id);

            // Check and update source store stock
            $fromStock = Stock::where('product_id', $transfer->product_id)
                             ->where('store_id', $transfer->from_store_id)
                             ->first();

            if (!$fromStock) {
                return response()->json([
                    'error' => 'Product not found in source store inventory'
                ], 404);
            }

            // Calculate quantity difference
            $quantityDifference = $request->quantity - $transfer->quantity;

            // Check if source store has enough stock for increased transfer
            if ($quantityDifference > 0 && $fromStock->quantity < $quantityDifference) {
                return response()->json([
                    'error' => 'Insufficient stock in source store. Available: ' . $fromStock->quantity,
                    'available' => $fromStock->quantity
                ], 400);
            }

            // Update source store stock
            $fromStock->update([
                'quantity' => $fromStock->quantity - $quantityDifference
            ]);

            $store = Store::with(['branch'])->findOrFail($request->toStoreId);
            $branchId = $store->branch->id;

            // Find or create destination store stock
            $toStock = Stock::firstOrCreate(
                [
                    'product_id' => $transfer->product_id,
                    'store_id' => $request->toStoreId,
                    'branch_id' => $branchId,
                ],
                [
                    'quantity' => 0,
                    'price' => $fromStock->price
                ]
            );

            // Update destination store stock
            $toStock->update([
                'quantity' => $toStock->quantity + $quantityDifference
            ]);

            // Update transfer record
            $transfer->update([
                'to_store_id' => $request->toStoreId,
                'from_store_id' => $request->fromStoreId,
                'quantity' => $request->quantity,
            ]);

            DB::commit();

            return response()->json([
                'success' => 'Transfer updated successfully.',
                'from_stock' => $fromStock->quantity,
                'to_stock' => $toStock->quantity
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to update transfer: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $transfer = Transfer::findOrFail($id);

            // Update source store (add back the transferred quantity)
            $fromStock = Stock::where('product_id', $transfer->product_id)
                             ->where('store_id', $transfer->from_store_id)
                             ->first();

            if (!$fromStock) {
                return response()->json([
                    'error' => 'Source store stock not found'
                ], 404);
            }

            $fromStock->update([
                'quantity' => $fromStock->quantity + $transfer->quantity
            ]);

            // Update destination store (remove the transferred quantity)
            $toStock = Stock::where('product_id', $transfer->product_id)
                           ->where('store_id', $transfer->to_store_id)
                           ->first();

            if ($toStock) {
                $toStock->update([
                    'quantity' => $toStock->quantity - $transfer->quantity
                ]);
            }

            $transfer->delete();

            DB::commit();

            return response()->json(['success' => 'Transfer deleted successfully.'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete transfer: ' . $e->getMessage()], 500);
        }
    }
}
