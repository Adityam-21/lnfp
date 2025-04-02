<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'name'  => $row['name'],   // Column in the CSV file
            'email' => $row['email'],
            'password' => bcrypt('password123') // Default password
        ]);
    }
}
