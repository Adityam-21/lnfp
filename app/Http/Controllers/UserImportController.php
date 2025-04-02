<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;

class UserImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.ImportUser'); // Ensure this file exists
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            Excel::import(new UserImport, $request->file('file'));
            return redirect()->back()->with('success', 'Users imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing users: ' . $e->getMessage());
        }
    }
}
