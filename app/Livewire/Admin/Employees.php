<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class Employees extends Component
{
    public $name, $email;
    public $employees;

    protected $rules = [
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
    ];

    public function mount()
    {
        $this->employees = User::employees()->get();
    }

    public function addEmployee()
    {
        $this->validate();

        $user = User::create([
            'name'  => $this->name,
            'email' => $this->email,
            'password' => bcrypt('password'), // Default password for all employees he could change it later
        ]);

        $user->assignRole('employee');

        session()->flash('success', 'Employee added successfully.');

        return redirect()->route('admin.employees');
    }

    public function render()
    {
        return view('livewire.admin.employees', ['employees' => User::employees()->get()])
            ->layout('layouts.app');
    }
}
