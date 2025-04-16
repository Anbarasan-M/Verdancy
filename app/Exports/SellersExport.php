<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class SellersExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        return User::where('role_id', 3)
            ->get(['name', 'email', 'phone_number', 'address', 'activity_status', 'approval_status', 'license_number']);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone Number',
            'Address',
            'Activity Status',
            'Approval Status',
            'License Number',
        ];
    }
}
