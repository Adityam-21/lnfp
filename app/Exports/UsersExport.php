<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
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
        return User::whereBetween('created_at', [$this->startDate, $this->endDate])->get(['id', 'name', 'email', 'created_at']);
    }

    public function headings(): array
    {
        return ["ID", "Name", "Email", "Created At"];
    }
}
