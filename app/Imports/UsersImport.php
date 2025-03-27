<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    public function model(array $row)
    {
        // Ensure the 'name' and 'email' keys exist before using them
        $name = $row['name'] ?? 'Default Name'; // Assign default if key is missing
        $email = $row['email'] ?? null; // Assign null if email is missing

        // Skip row if email is missing
        if (!$email) {
            \Log::warning("Skipping row: Email is missing", $row);
            return null;
        }

        return new User([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($row['password'] ?? 'default123'), // Ensure password exists
        ]);
    }
}