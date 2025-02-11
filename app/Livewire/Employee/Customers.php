<?php

namespace App\Livewire\Employee;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Customers extends Component
{
    public $name, $email;
    public $customers, $employees;

    protected function rules()
    {
        return [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ];
    }

    public function mount()
    {
        $this->employees = User::employees()->get();
        $this->customers = User::assignedCustomers(Auth::user()->id)->customers()->get();
    }

    public function addCustomer()
    {
        $this->validate();

        $user = User::create([
            'name'  => $this->name,
            'email' => $this->email,
            'password' => bcrypt('password'), // Default password for all employees he could change it later
        ]);

        $user->assignRole('customer');

        Customer::create([
            'user_id' => $user->id,
            'assigned_to' => Auth::user()->id,
            'created_by' => Auth::user()->id,
        ]);

        session()->flash('success', 'Customer added successfully.');

        return redirect()->route('employee.customers');
    }

    public function render()
    {
        return view('livewire.employee.customers', [
            'employees' => User::employees()->get(),
            'customers' => User::assignedCustomers(Auth::user()->id)->customers()->get(),
        ])->layout('layouts.app');
    }
}
