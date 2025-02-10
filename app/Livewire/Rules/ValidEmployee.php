<?php

namespace App\Livewire\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidEmployee implements ValidationRule
{
    public function validate($attribute, $value, $fail): void
    {
        if (!User::where('id', $value)->whereHas('roles', function ($query) {
            $query->where('name', 'employee');
        })->exists()) {
            $fail('The selected assigned_to is invalid.');
        }
    }
}
