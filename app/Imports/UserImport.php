<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class UserImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $errors = []; // Store error messages

        foreach ($rows as $index => $row) {
            // Trim spaces and ensure valid input
            $email = trim($row['email'] ?? '');
            $name = trim($row['name'] ?? '');
            $password = trim($row['password'] ?? ''); // Ensure password is provided

            // Check if user already exists
            $existingUser = User::where('email', $email)->first();

            if ($existingUser) {
                // Mark as duplicate
                $errors[] = "Row " . ($index + 2) . " Error: Duplicate email - Not Imported";
                continue; // Skip inserting duplicate
            }

            // Validation rules
            $validator = Validator::make($row->toArray(), [
                'name' => 'required|string|min:3',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) {
                // Collect errors for each row
                $errors[] = "Row " . ($index + 2) . " Error: " . implode(", ", $validator->errors()->all());
                continue; // Skip inserting invalid row
            }

            // If valid, insert into DB
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password), // Encrypt password
            ]);
        }

        // If errors exist, throw exception to be caught in the controller
        if (!empty($errors)) {
            throw new \Exception(implode(" | ", $errors));
        }
    }
}
