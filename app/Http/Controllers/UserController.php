<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function export() {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function import(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);
        
        Excel::import(new UsersImport, $request->file('file'));

        return back()->with('success', 'Users imported successfully.');
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->forceDelete(); // Permanently delete the user

        return redirect()->route('admin.dashboard')->with('success', 'User permanently deleted.');
    }

    // ✅ Soft Delete Function
    public function softDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Soft delete (moves user to "trashed" state)
        
        return redirect()->route('admin.dashboard')->with('success', 'User soft deleted successfully.');
    }
}
