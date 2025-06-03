<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class BranchController extends Controller
{
    //
    public function index() {
        $branches = Branch::all();

        return response()->json($branches);
    }

    public function create(Request $request) {
        try {
            $branch = Branch::create([
                'name' => $request->name,
            ]);

            Role::create([
                'name' => 'branch' . $branch->id,
            ]);

            return response()->json(['success' => 'Branch created successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create branch: ' . $e->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {
        try {
            $branch = Branch::findOrFail($id);

            $branch->update([
                'name' => $request->name,
            ]);

            return response()->json(['success' => 'Branch updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' =>  'Error updating Branch.', $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branch->delete();

            return response()->json(['success' => 'Branch deleted Succesful'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error Deleting Branch', $e->getMessage()], 500);
        }
    }
}

