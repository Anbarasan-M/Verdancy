<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash; // Import the Hash facade
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiceProvidersImport implements ToModel, WithHeadings
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row[0], // Assuming 'name' is in the first column
            'email' => $row[1], // 'email' in the second column
            'password' => Hash::make($row[2]), // Use Hash::make to hash the password
            'phone_number' => $row[3],
            'address' => $row[4],
            'activity_status' => 'active', // Set activity_status to 'active'
            'approval_status' => 'approved', // Set approval_status to 'approved'
            'license_number' => $row[5],
            'role_id' => 5, // Set role_id to 5 for service providers
        ]);
    }

    /**
     * Return the headings for the import file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Password',
            'Phone Number',
            'Address',
            'License Number',
        ];
    }
}
