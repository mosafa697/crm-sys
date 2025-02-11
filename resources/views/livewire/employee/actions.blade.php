<div>
    <h2 class="text-lg font-bold mb-4">Log Customer Actions</h2>

    @if (session()->has('success'))
        <div class="bg-green-500 text-white p-2 mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="logAction">
        <select wire:model="customer_id" class="border p-2">
            <option value="">Select Customer</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            @endforeach
        </select>

        <select wire:model="type" class="border p-2">
            <option value="call">Call</option>
            <option value="visit">Visit</option>
            <option value="follow-up">Follow-up</option>
            {{-- TODO: make it dynamic and store it in seeder  --}}
        </select>

        <textarea wire:model="result" placeholder="Action Result" class="border p-2"></textarea>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2">Log Action</button>
    </form>

    <h3 class="mt-4">My Actions</h3>
    <ul>
        @foreach ($actions as $action)
            <li>{{ $action->type }} - {{ $action->result }} ({{ $action->created_at->diffForHumans() }})</li>
            <li>{{ $action->customer?->name }}</li>
        @endforeach
    </ul>
</div>
