<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class UserImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.ImportUser'); // Ensure this file exists
    }

    public function import(Request $request)
    {
        // Check if file is uploaded before validation
        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'No file uploaded.');
        }

        // Get the uploaded file
        $file = $request->file('file');

        // Ensure uploaded file is valid before proceeding
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Uploaded file is invalid.');
        }

        // Validate the file input
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ], [
            'file.mimes' => 'The file must be a valid CSV or Excel file (xlsx, xls, csv).',
            'file.required' => 'Please upload a file.',
            'file.max' => 'The file size should not exceed 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Process the file
            Excel::import(new UserImport, $file);
            return redirect()->back()->with('success', 'Users imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
