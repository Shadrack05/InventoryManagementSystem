<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Http\Requests\updateBranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    //
    public function index() {
        $branches = Branch::with(['stores'])->get();

        return response()->json($branches);
    }

    public function create(BranchRequest $request) {
        try {
            $branch = Branch::create([
                'name' => $request->name,
            ]);

            Role::create([
                'name' => 'branch' . $branch->id,
                'guard_name' => 'web',
            ]);

            return response()->json(['success' => 'Branch created successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create branch: ' . $e->getMessage()], 500);
        }

    }

    public function update(updateBranchRequest $request, $id) {
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
            DB::beginTransaction();

            $branch = Branch::findOrFail($id);

            // Check and delete associated role
            $roleName = 'branch' . $id;
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                // Remove role from any users that have it
                $role->users()->sync([]);
                $role->delete();
            }

            // Delete the branch
            $branch->delete();

            DB::commit();

            return response()->json([
                'success' => 'Branch and associated role deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Error deleting branch: ' . $e->getMessage()
            ], 500);
        }
    }
}

