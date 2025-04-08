<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\UsersExport;
use App\Exports\FilteredUsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    // ✅ NEW: Show paginated users on dashboard
    public function index()
    {
        $users = User::paginate(10); // Paginate users, 10 per page
        return view('admin.dashboard', compact('users'));
    }

    public function export()
    {
        $startDate = null;
        $endDate = null;

        return Excel::download(new UsersExport($startDate, $endDate), 'users.xlsx');
    }

    public function userImport(Request $request)
    {
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
        return view('admin.user.edit-user', compact('user'));
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
        $user->forceDelete();

        return redirect()->route('admin.dashboard')->with('success', 'User permanently deleted.');
    }

    public function softDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User soft deleted successfully.');
    }

    public function exportFiltered(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        return Excel::download(new FilteredUsersExport($request->start_date, $request->end_date), 'filtered_users.xlsx');
    }
}
