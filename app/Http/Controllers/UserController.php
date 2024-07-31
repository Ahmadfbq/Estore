<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{

    public function getUsers()
    {
        $orders = User::latest()->get();
        return response()->json($orders);
    }

    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->email != 'ahmdb625@gmail.com') {
            return redirect()->back()->with('error', 'Only one user can be an admin.');
        }
        
        $user->role = 'admin';
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully!');
    }
}
