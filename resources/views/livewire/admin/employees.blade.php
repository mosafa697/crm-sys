<div class="px-40">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Employee Management
        </h2>
        @if (session()->has('success'))
            <div class="bg-green-500 text-white p-2 mb-3">
                {{ session('success') }}
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <form wire:submit.prevent="addEmployee">
            <input type="text" wire:model="name" placeholder="Name" class="border p-2">
            <input type="email" wire:model="email" placeholder="Email" class="border p-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Add Employee</button>
        </form>

        <h3 class="mt-4">Employees List:</h3>
        <ul>
            @forelse ($employees as $employee)
                <li>{{ ++$loop->index }} - {{ $employee->name }} - {{ $employee->email }}</li>
                {{-- add list customers --}}
            @empty
                <li>No employees found.</li>
            @endforelse
        </ul>
    </div>
</div>
