<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Shelter Operations Dashboard</h1>
        <p class="text-sm text-gray-600">
            {{ $activation?->name ?? 'No activation selected' }}
        </p>
    </div>

    <div class="grid grid-cols-2 gap-4 md:grid-cols-6">
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="text-sm text-gray-500">Shelters</div>
            <div class="text-2xl font-bold">{{ $summary['total_shelters'] }}</div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="text-sm text-gray-500">Open</div>
            <div class="text-2xl font-bold">{{ $summary['open_shelters'] }}</div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="text-sm text-gray-500">Capacity</div>
            <div class="text-2xl font-bold">{{ $summary['capacity'] }}</div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="text-sm text-gray-500">Occupancy</div>
            <div class="text-2xl font-bold">{{ $summary['occupancy'] }}</div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="text-sm text-gray-500">Available</div>
            <div class="text-2xl font-bold">{{ $summary['availability'] }}</div>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <div class="text-sm text-gray-500">Pets</div>
            <div class="text-2xl font-bold">{{ $summary['pets'] }}</div>
        </div>
    </div>

    <div class="rounded-lg bg-white shadow">
        <div class="border-b p-4">
            <h2 class="font-semibold">Shelter Status</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Shelter</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-right">Capacity</th>
                        <th class="px-4 py-2 text-right">Occupancy</th>
                        <th class="px-4 py-2 text-right">Available</th>
                        <th class="px-4 py-2 text-left">Last Census</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($activationShelters as $activationShelter)
                        <tr>
                            <td class="px-4 py-2 font-medium">
                                <a href="{{ route('shelter-board.operations.show', $activationShelter) }}" class="text-blue-700 hover:underline">
                                    {{ $activationShelter->shelter->name }}
                                </a>
                            </td>
                            <td class="px-4 py-2">{{ $activationShelter->status }}</td>
                            <td class="px-4 py-2 text-right">{{ $activationShelter->current_capacity }}</td>
                            <td class="px-4 py-2 text-right">{{ $activationShelter->calculated_occupancy }}</td>
                            <td class="px-4 py-2 text-right">{{ $activationShelter->availability }}</td>
                            <td class="px-4 py-2">
                                {{ optional($activationShelter->latestCensusReport?->reported_at)->format('m/d/Y H:i') ?? 'None' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">No shelters assigned.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-lg bg-white shadow">
        <div class="border-b p-4">
            <h2 class="font-semibold">Recent Activity</h2>
        </div>
        <div class="divide-y">
            @forelse($recentLogs as $log)
                <div class="p-4 text-sm">
                    <div class="font-medium">{{ $log->activationShelter->shelter->name }} - {{ $log->category }}</div>
                    <div>{{ $log->entry }}</div>
                    <div class="text-xs text-gray-500">{{ $log->logged_at?->format('m/d/Y H:i') }}</div>
                </div>
            @empty
                <div class="p-4 text-sm text-gray-500">No activity logged yet.</div>
            @endforelse
        </div>
    </div>
</div>
