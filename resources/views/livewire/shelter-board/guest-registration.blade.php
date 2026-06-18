<div class="mx-auto max-w-3xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold">Register Guest</h1>
        <p class="text-sm text-gray-600">{{ $activationShelter->shelter->name }} | {{ $activationShelter->activation->name }}</p>
    </div>

    <div class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Identity</h2>

        <div class="grid gap-3 md:grid-cols-3">
            <input wire:model="first_name" class="rounded border p-2" placeholder="First Name *">
            <input wire:model="middle_name" class="rounded border p-2" placeholder="Middle Name">
            <input wire:model="last_name" class="rounded border p-2" placeholder="Last Name *">
            <input type="date" wire:model="date_of_birth" class="rounded border p-2">
            <input wire:model="gender" class="rounded border p-2" placeholder="Gender">
            <input wire:model="driver_license" class="rounded border p-2" placeholder="Driver License">
        </div>

        @error('first_name') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
        @error('last_name') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
    </div>

    <div class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Contact</h2>

        <div class="grid gap-3">
            <input wire:model="address" class="rounded border p-2" placeholder="Address">
            <div class="grid gap-3 md:grid-cols-3">
                <input wire:model="phone_primary" class="rounded border p-2" placeholder="Primary Phone">
                <input wire:model="phone_secondary" class="rounded border p-2" placeholder="Secondary Phone">
                <input wire:model="email" class="rounded border p-2" placeholder="Email">
            </div>
        </div>
    </div>

    <div class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Shelter Information</h2>

        <div class="grid gap-3 md:grid-cols-2">
            <input wire:model="family_group_id" class="rounded border p-2" placeholder="Family Group ID">
            <label class="flex items-center gap-2 rounded border p-2">
                <input type="checkbox" wire:model="has_special_needs">
                <span>Special Needs</span>
            </label>
        </div>
    </div>

    <div class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Animals</h2>

        <div class="grid gap-3 md:grid-cols-2">
            <input type="number" min="0" wire:model="pet_count" class="rounded border p-2" placeholder="Pet Count">
            <input wire:model="pet_description" class="rounded border p-2" placeholder="Pet Description">
        </div>
    </div>

    <div class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Notes</h2>
        <textarea wire:model="notes" class="w-full rounded border p-2"></textarea>
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('shelter-board.operations.show', $activationShelter) }}" class="rounded border px-4 py-2">Cancel</a>
        <button wire:click="registerAndCheckIn" class="rounded bg-blue-700 px-4 py-2 text-white">
            Register and Check In
        </button>
    </div>
</div>
