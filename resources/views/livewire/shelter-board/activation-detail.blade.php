<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold">{{ $activation->name }}</h1>
        <p class="text-sm text-gray-600">{{ $activation->incident_type }} | {{ $activation->status }}</p>
    </div>

    @if(session()->has('message'))
        <div class="rounded bg-green-50 p-3 text-green-800">{{ session('message') }}</div>
    @endif

    @if($canManageActivation)
        <div class="rounded-lg bg-white p-4 shadow">
            <h2 class="mb-3 font-semibold">Assign Shelters</h2>
            <div class="grid gap-2 md:grid-cols-3">
                @foreach($shelters as $shelter)
                    <label class="flex items-center gap-2 rounded border p-2">
                        <input type="checkbox" wire:model="selectedShelters" value="{{ $shelter->id }}">
                        <span>{{ $shelter->name }}</span>
                    </label>
                @endforeach
            </div>
            <button wire:click="saveShelters" class="mt-4 rounded bg-blue-700 px-4 py-2 text-white">Save Shelters</button>
        </div>
    @endif

    <div class="rounded-lg bg-white shadow">
        <div class="border-b p-4"><h2 class="font-semibold">Activation Shelters</h2></div>
        <div class="divide-y">
            @forelse($activationShelters as $activationShelter)
                <div class="flex items-center justify-between p-4">
                    <div>
                        <div class="font-medium">{{ $activationShelter->shelter->name }}</div>
                        <div class="text-sm text-gray-600">{{ $activationShelter->status }}</div>
                    </div>
                    <a href="{{ route('shelter-board.operations.show', $activationShelter) }}" class="rounded bg-gray-900 px-3 py-2 text-sm text-white">Open Operations</a>
                </div>
            @empty
                <div class="p-4 text-sm text-gray-500">No shelters assigned.</div>
            @endforelse
        </div>
    </div>
</div>
