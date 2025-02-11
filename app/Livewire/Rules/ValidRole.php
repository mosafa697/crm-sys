<?php

namespace App\Livewire\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidRole implements ValidationRule
{
    protected $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function validate($attribute, $value, $fail): void
    {
        if (!User::where('id', $value)->whereHas('roles', function ($query) {
            $query->where('name', $this->role);
        })->exists()) {
            $fail('The selected assigned_to is invalid.');
        }
    }
}
