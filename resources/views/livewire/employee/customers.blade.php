<div class="px-40 py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Customer Management
        </h2>
        @if (session()->has('success'))
            <div class="bg-green-500 text-white p-2 mb-3">
                {{ session('success') }}
            </div>
        @endif
    </x-slot>

    <form wire:submit.prevent="addCustomer">
        <input type="text" wire:model="name" placeholder="Name" class="border p-2">
        <input type="email" wire:model="email" placeholder="Email" class="border p-2">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Add Customer</button>
    </form>

    <h3 class="mt-4">My Customers</h3>
    <ul>
        @forelse ($customers as $customer)
            <li>{{ ++$loop->index }} - {{ $customer->name }}</li>
        @empty
            <li>No customers found.</li>
        @endforelse
    </ul>
</div>
