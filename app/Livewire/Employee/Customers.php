<?php

namespace App\Livewire\Employee;

use App\Livewire\Rules\ValidEmployee;
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
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'assigned_to' => ['nullable', new ValidEmployee()],
        ];
    }

    public function mount()
    {
        $this->employees = User::employees()->get();
        $this->customers = User::assignedCustomers(Auth::user()->id)->get();
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

        return redirect()->route('employee.customers');
    }

    public function render()
    {
        return view('livewire.employee.customers', [
            'employees' => User::employees()->all(),
            'customers' => User::assignedCustomers(Auth::user()->id)->get(),
        ]);
    }
}
