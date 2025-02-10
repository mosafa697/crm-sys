<div>
    <h2 class="text-lg font-bold mb-4">Customer Management</h2>

    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-2 mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="addCustomer">
        <input type="text" wire:model="name" placeholder="Name" class="border p-2">
        <input type="email" wire:model="email" placeholder="Email" class="border p-2">

        <select wire:model="assigned_to" class="border p-2">
            <option value="">Select Employee</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Add Customer</button>
    </form>

    <h3 class="mt-4">Customers List</h3>
    <ul>
        @foreach ($customers as $customer)
            <li>
                {{ $customer->name }} - {{ $customer->email }}
                (Assigned to: {{ optional($customer->employee)->name ?? 'No Employee' }})
                {{-- add change employee button or form --}}
            </li>
        @endforeach
    </ul>
</div>
