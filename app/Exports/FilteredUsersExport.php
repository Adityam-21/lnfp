<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon; // ✅ For date formatting

class FilteredUsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return User::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select('id', 'name', 'email', 'created_at')
            ->get();
    }

    public function headings(): array
    {
        return ["ID", "Name", "Email", "Created At"];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            Carbon::parse($user->created_at)->format('Y-m-d H:i:s') // ✅ Date formatted correctly
        ];
    }
}
