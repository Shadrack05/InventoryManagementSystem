<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index() {
        try {
            $users = User::with('roles')->get();
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error Editing Admin', $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        try {
            $user = User::find($id);

            $user->syncRoles($request->rolesArray);

            return response()->json(['success' => 'Admin updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' =>  'Error updating Admin.', $e->getMessage()], 500);
        }
    }
}
