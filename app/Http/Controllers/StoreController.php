<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class StoreController extends Controller
{
    //
    public function index() {
        $givings = Store::with(['branch'])->get();;

        return response()->json($givings);
    }

    public function create(Request $request) {
        try {
            $store = Store::create([
                'name' => $request->name,
                'branch_id' => $request->branchId,
            ]);

            Role::create([
                'name' => 'store' . $store->id,
            ]);

        return response()->json(['success' => 'Store recorded successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create store: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $store = Store::findOrFail($id);
            $store->update([
                'name' => $request->name,
                'branch_id' => $request->branch_id,
            ]);

            return response()->json(['success' => 'Store updated successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update store: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id) {
        try {
            $store = Store::findOrFail($id);
            $store->delete();

            return response()->json(['success' => 'Store deleted successfully.'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete store: ' . $e->getMessage()], 500);
        }
    }
}
