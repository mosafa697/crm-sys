<?php

namespace App\Livewire\Admin;

use App\Livewire\Rules\ValidRole;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Customers extends Component
{
    public $name, $email, $assigned_to;
    public $customers, $employees;

    protected function rules()
    {
        return [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'assigned_to' => ['nullable', new ValidRole('employee')],
        ];
    }

    public function mount()
    {
        $this->customers = User::customers()->get();
        $this->employees = User::employees()->get();
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
            'assigned_to' => $this->assigned_to,
            'created_by' => Auth::user()->id,
        ]);

        session()->flash('success', 'Customer added successfully.');

        return redirect()->route('admin.customers');
    }

    public function render()
    {
        return view('livewire.admin.customers', [
            'customers' => User::customers()->get(),
            'employees' => User::employees()->get()
        ])->layout('layouts.app');
    }
}
