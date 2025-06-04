<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    public function index() {
        $Roles = Role::all();

        return response()->json($Roles);
    }

    public function create(Request $request) {
        try {
            Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);

            return response()->json(['success' => 'Role Created successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create Role: ' . $e->getMessage()], 500);
        }

    }

    public function update(Request $request, $id) {
        // Find the Role by ID
        try {
            $Role = Role::findOrFail($id);

            // Update the Role's details
            $Role->update([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);

            return response()->json(['success' => 'Role updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' =>  'Error updating route.', $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response()->json(['success' => 'Role deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete Role: ' . $e->getMessage()], 500);
        }
    }
}
