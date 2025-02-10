<?php

use App\Livewire\Admin\Customers;
use App\Livewire\Admin\Employees;
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
    Route::get('/admin/customers', Customers::class)->name('admin.customers');
});

require __DIR__ . '/auth.php';
