<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employers = User::factory()->count(2)->create();

        foreach ($employers as $employer) {
            $employer->assignRole('employer');
        }

        $userCustomers = User::factory()->count(6)->create();

        foreach ($userCustomers as $userCustomer) {
            $userCustomer->assignRole('customer');

            Customer::create([
                'user_id' => $userCustomer->id,
                'assigned_to' => $employers->random()->id,
                'created_by' => $employers->random()->id
            ]);
        }
    }
}
