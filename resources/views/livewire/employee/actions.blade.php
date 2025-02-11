<div class="px-40 py-12">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Customers Actions
        </h2>
        @if (session()->has('success'))
            <div class="bg-green-500 text-white p-2 mb-3">
                {{ session('success') }}
            </div>
        @endif
    </x-slot>

    <form wire:submit.prevent="logAction">
        <select wire:model="customer_id" class="border m-1 px-10">
            <option value="">Select Customer</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            @endforeach
        </select>

        <select wire:model="type" class="border px-10">
            <option value="">Select Action</option>
            <option value="call">Call</option>
            <option value="visit">Visit</option>
            <option value="follow-up">Follow-up</option>
            {{-- TODO: make it dynamic and store it in seeder  --}}
        </select>
        <br>
        <textarea wire:model="result" placeholder="Action Result" class="border m-1 px-15"></textarea>
        <br>
        <button type="submit" class="bg-blue-500 text-white m-1 px-4 py-2">Log Action</button>
    </form>

    <h2 class="mt-4">My Actions:</h2>
    <ul>
        @forelse ($actions as $action)
            <li>{{ $action->customer?->name }}: {{ $action->type }} / {{ $action->result }}
                ({{ $action->created_at->diffForHumans() }})</li>
        @empty
            <h3>No Actions yet</h3>
        @endforelse
    </ul>
</div>
