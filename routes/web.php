<?php

use App\Livewire\Admin\Customers as AdminCustomers;
use App\Livewire\Admin\Employees;
use App\Livewire\Employee\Actions;
use App\Livewire\Employee\Customers as EmployeeCustomers;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/employees', Employees::class)->name('admin.employees');
    Route::get('/admin/customers', AdminCustomers::class)->name('admin.customers');
});

Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/customers', EmployeeCustomers::class)->name('employee.customers');
    Route::get('/employee/actions', Actions::class)->name('employee.actions');
});

require __DIR__ . '/auth.php';
