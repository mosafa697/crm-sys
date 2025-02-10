<div>
    <h2 class="text-lg font-bold mb-4">Employee Management</h2>

    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-2 mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="addEmployee">
        <input type="text" wire:model="name" placeholder="Name" class="border p-2">
        <input type="email" wire:model="email" placeholder="Email" class="border p-2">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Add Employee</button>
    </form>

    <h3 class="mt-4">Employees List</h3>
    <ul>
        @foreach ($employees as $employee)
            <li>{{ $employee->name }} - {{ $employee->email }}</li>
            {{-- add list customers --}}
        @endforeach
    </ul>
</div>
