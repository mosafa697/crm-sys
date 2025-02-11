<?php

namespace App\Livewire\Employee;

use App\Livewire\Rules\ValidRole;
use App\Models\Action;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Actions extends Component
{
    public $customer_id, $type, $result;
    public $customers, $actions;

    protected function rules()
    {
        return [
            'customer_id' => ['required', new ValidRole('customer')],
            'type'        => 'required|string', // in:call,visit,follow-up
            'result'      => 'required|string|max:255',
        ];
    }

    public function mount()
    {
        $this->customers = User::assignedCustomers(Auth::user()->id)->customers()->get();
        $this->actions = Action::where('employee_id', Auth::id())->with('customer')->latest()->get();
    }

    public function logAction()
    {
        $this->validate();

        Action::create([
            'employee_id' => Auth::id(),
            'customer_id' => $this->customer_id,
            'type'        => $this->type,
            'result'      => $this->result,
        ]);

        session()->flash('success', 'Action logged successfully.');

        return redirect()->route('employee.actions');
    }

    public function render()
    {
        return view('livewire.employee.actions', [
            'customers' => User::assignedCustomers(Auth::user()->id)->customers()->get(),
            'actions' => Action::where('employee_id', Auth::id())->with('customer')->latest()->get(),
        ])->layout('layouts.app', ['header' => 'Actions']);
    }
}
