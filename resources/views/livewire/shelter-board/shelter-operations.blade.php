<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold">{{ $activationShelter->shelter->name }}</h1>
        <p class="text-sm text-gray-600">{{ $activationShelter->activation->name }} | {{ $activationShelter->status }}</p>
    </div>

    @if(session()->has('message'))
        <div class="rounded bg-green-50 p-3 text-green-800">{{ session('message') }}</div>
    @endif
    @if(session()->has('error'))
        <div class="rounded bg-red-50 p-3 text-red-800">{{ session('error') }}</div>
    @endif

    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded bg-white p-4 shadow"><div class="text-sm text-gray-500">Capacity</div><div class="text-2xl font-bold">{{ $activationShelter->current_capacity }}</div></div>
        <div class="rounded bg-white p-4 shadow"><div class="text-sm text-gray-500">Occupancy</div><div class="text-2xl font-bold">{{ $activationShelter->calculated_occupancy }}</div></div>
        <div class="rounded bg-white p-4 shadow"><div class="text-sm text-gray-500">Available</div><div class="text-2xl font-bold">{{ $activationShelter->availability }}</div></div>
        <div class="rounded bg-white p-4 shadow"><div class="text-sm text-gray-500">Last Census</div><div class="text-lg font-bold">{{ optional($latestCensus?->reported_at)->format('H:i') ?? 'None' }}</div></div>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        @if($canOpenShelter || $canCloseShelter)
            <div class="rounded bg-white p-4 shadow">
                <h2 class="mb-3 font-semibold">Shelter Actions</h2>
                @if($canOpenShelter)
                    <label class="text-sm">Opening Notes</label>
                    <textarea wire:model="openingNotes" class="mb-3 w-full rounded border p-2"></textarea>
                    <button wire:click="openShelter" class="rounded bg-green-700 px-4 py-2 text-white">Open Shelter</button>
                @endif
                @if($canCloseShelter)
                    <hr class="my-4">
                    <label class="text-sm">Closing Notes</label>
                    <textarea wire:model="closingNotes" class="mb-3 w-full rounded border p-2"></textarea>
                    <button wire:click="closeShelter" class="rounded bg-red-700 px-4 py-2 text-white">Close Shelter</button>
                @endif
            </div>
        @endif

        @if($canSubmitCensus)
            <div class="rounded bg-white p-4 shadow">
                <h2 class="mb-3 font-semibold">Submit Census</h2>
                <div class="grid grid-cols-2 gap-3">
                    <input type="number" min="0" wire:model="clients" class="rounded border p-2" placeholder="Clients">
                    <input type="number" min="0" wire:model="caregivers" class="rounded border p-2" placeholder="Caregivers">
                    <input type="number" min="0" wire:model="staff" class="rounded border p-2" placeholder="Staff">
                    <input type="number" min="0" wire:model="pets" class="rounded border p-2" placeholder="Pets">
                    <input type="number" min="0" wire:model="serviceAnimals" class="rounded border p-2" placeholder="Service Animals">
                </div>
                <textarea wire:model="censusNotes" class="mt-3 w-full rounded border p-2" placeholder="Notes"></textarea>
                <button wire:click="submitCensus" class="mt-3 rounded bg-blue-700 px-4 py-2 text-white">Submit Census</button>
            </div>
        @endif
    </div>

    @if($canAddOperationalLog)
        <div class="rounded bg-white p-4 shadow">
            <h2 class="mb-3 font-semibold">Operational Log</h2>
            <div class="grid gap-3 md:grid-cols-4">
                <select wire:model="logCategory" class="rounded border p-2">
                    <option>General</option><option>Medical</option><option>Transportation</option><option>Security</option><option>Logistics</option><option>Staffing</option><option>Facilities</option>
                </select>
                <input wire:model="logEntry" class="rounded border p-2 md:col-span-2" placeholder="Log entry">
                <button wire:click="addLogEntry" class="rounded bg-gray-900 px-4 py-2 text-white">Add Log</button>
            </div>
        </div>
    @endif

    <div class="rounded bg-white p-4 shadow">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="font-semibold">Guests</h2>
            @if($canRegisterGuests)
                <a href="{{ route('shelter-board.guests.search', $activationShelter) }}" class="rounded bg-blue-700 px-3 py-2 text-sm text-white">
                    Find / Register Guest
                </a>
            @endif
        </div>
        <input wire:model.debounce.400ms="guestSearch" class="mb-3 w-full rounded border p-2" placeholder="Search guests...">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50"><tr><th class="px-4 py-2 text-left">Name</th><th class="px-4 py-2 text-left">Status</th><th class="px-4 py-2 text-left">Checked In</th><th class="px-4 py-2 text-left">Checked Out</th><th class="px-4 py-2 text-right">Action</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($guestStays as $stay)
                        <tr>
                            <td class="px-4 py-2">{{ $stay->guest->full_name }}</td>
                            <td class="px-4 py-2">{{ $stay->status }}</td>
                            <td class="px-4 py-2">{{ $stay->checked_in_at?->format('m/d H:i') }}</td>
                            <td class="px-4 py-2">{{ $stay->checked_out_at?->format('m/d H:i') }}</td>
                            <td class="px-4 py-2 text-right">@can('checkOut', $stay) @if(!$stay->checked_out_at)<button wire:click="checkOutGuest({{ $stay->id }})" class="rounded bg-red-600 px-3 py-1 text-xs text-white">Check Out</button>@endif @endcan</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No guests registered.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded bg-white p-4 shadow">
        <h2 class="mb-3 font-semibold">Recent Logs</h2>
        <div class="divide-y">
            @forelse($recentLogs as $log)
                <div class="py-2 text-sm"><strong>{{ $log->category }}</strong>: {{ $log->entry }} <span class="text-xs text-gray-500">({{ $log->logged_at?->format('m/d H:i') }})</span></div>
            @empty
                <div class="py-2 text-sm text-gray-500">No log entries.</div>
            @endforelse
        </div>
    </div>
</div>
