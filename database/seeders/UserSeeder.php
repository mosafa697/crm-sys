<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = User::factory()->count(2)->create();

        foreach ($employees as $employee) {
            $employee->assignRole('employee');
        }

        $userCustomers = User::factory()->count(6)->create();

        foreach ($userCustomers as $userCustomer) {
            $userCustomer->assignRole('customer');

            Customer::create([
                'user_id' => $userCustomer->id,
                'assigned_to' => $employees->random()->id,
                'created_by' => $employees->random()->id
            ]);
        }
    }
}
