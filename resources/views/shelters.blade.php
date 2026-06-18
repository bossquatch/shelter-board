<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shelter Operations Board</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800">
<div class="min-h-screen">

    <!-- Header -->
    <header class="bg-slate-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-5">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Shelter Operations Board</h1>
                    <p class="text-slate-300 mt-1">
                        Incident: Hurricane Example | Operational Period: Day 1 | Last Updated: 08:15 AM
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 w-full lg:w-auto">
                    <input
                            type="text"
                            placeholder="Search shelter..."
                            class="rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500"
                    />

                    <select class="rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option>All Statuses</option>
                        <option>Open</option>
                        <option>Standby</option>
                        <option>Near Capacity</option>
                        <option>Full</option>
                        <option>Closed</option>
                    </select>

                    <select class="rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option>All Types</option>
                        <option>General Population</option>
                        <option>Special Needs</option>
                        <option>Pet-Friendly</option>
                    </select>

                    <select class="rounded-lg border border-slate-700 bg-slate-800 px-3 py-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option>All Municipalities</option>
                        <option>Auburndale</option>
                        <option>Bartow</option>
                        <option>Lakeland</option>
                        <option>Haines City</option>
                    </select>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-6 space-y-6">

        <!-- Summary Cards -->

        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-3 gap-4">

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <p class="text-sm font-medium text-slate-500">Total Population</p>
                <p class="text-3xl font-bold mt-2">3,218</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <p class="text-sm font-medium text-slate-500">Total Capacity</p>
                <p class="text-3xl font-bold mt-2">9,124</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <p class="text-sm font-medium text-slate-500">Available Capacity</p>
                <p class="text-3xl font-bold mt-2">5,906</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <p class="text-sm font-medium text-slate-500">Shelters</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 text-xs my-2">
                    <div>
                        <div class="">Total</div>
                        <div class="text-3xl font-bold mt-2">34</div>
                    </div>
                    <div>
                        <div class="">Open</div>
                        <div class="text-3xl font-bold mt-2">12</div>
                    </div>
                    <div>
                        <div class="">Stand By</div>
                        <div class="text-3xl font-bold mt-2">22</div>
                    </div>
                    <div>
                        <div class="">Near Capacity</div>
                        <div class="text-3xl font-bold mt-2">3</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-amber-200 p-5 bg-amber-50">
                <p class="text-sm font-medium text-amber-700">Near Capacity</p>
                <p class="text-3xl font-bold mt-2 text-amber-800">3</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-red-200 p-5 bg-red-50">
                <p class="text-sm font-medium text-red-700">Shelters with Issues</p>
                <p class="text-3xl font-bold mt-2 text-red-800">2</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <p class="text-sm font-medium text-slate-500">General Population</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 text-xs my-2">
                    <div>
                        <div class="">Occupants</div>
                        <div class="text-3xl font-bold mt-2">534</div>
                    </div>
                    <div>
                        <div class="">Capacity</div>
                        <div class="text-3xl font-bold mt-2">2,476</div>
                    </div>
                    <div>
                        <div class="">Available</div>
                        <div class="text-3xl font-bold mt-2">1,942</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <p class="text-sm font-medium text-slate-500">Pet Friendly</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 text-xs my-2">
                    <div>
                        <div class="">Occupants</div>
                        <div class="text-3xl font-bold mt-2">534</div>
                    </div>
                    <div>
                        <div class="">Capacity</div>
                        <div class="text-3xl font-bold mt-2">2,476</div>
                    </div>
                    <div>
                        <div class="">Available</div>
                        <div class="text-3xl font-bold mt-2">1,942</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">
                <p class="text-sm font-medium text-slate-500">Special Needs</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 text-xs my-2">
                    <div>
                        <div class="">Occupants</div>
                        <div class="text-3xl font-bold mt-2">534</div>
                    </div>
                    <div>
                        <div class="">Capacity</div>
                        <div class="text-3xl font-bold mt-2">2,476</div>
                    </div>
                    <div>
                        <div class="">Available</div>
                        <div class="text-3xl font-bold mt-2">1,942</div>
                    </div>
                </div>
            </div>

        </section>

        <!-- Map + Alerts -->
        <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Map -->
            <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold">Shelter Map</h2>
                    <span class="text-sm text-slate-500">Status by location</span>
                </div>
                <div class="h-[420px] bg-slate-200 flex items-center justify-center text-slate-500 text-lg">
                    Map Placeholder
                </div>
            </div>

            <!-- Alerts -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
                <div class="px-5 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold">Priority Alerts</h2>
                    <p class="text-sm text-slate-500 mt-1">Shelters needing attention</p>
                </div>

                <div class="divide-y divide-slate-200">
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-900">Auburndale High School</p>
                                <p class="text-sm text-slate-600 mt-1">92% occupied. Approaching full capacity.</p>
                            </div>
                            <span class="shrink-0 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-1">
                                Near Full
                            </span>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-900">Bartow High School Cafeteria</p>
                                <p class="text-sm text-slate-600 mt-1">Night shift staffing shortfall reported.</p>
                            </div>
                            <span class="shrink-0 rounded-full bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-1">
                  Staffing
                </span>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-900">Caldwell Elementary</p>
                                <p class="text-sm text-slate-600 mt-1">No update received in 3 hours.</p>
                            </div>
                            <span class="shrink-0 rounded-full bg-slate-200 text-slate-700 text-xs font-semibold px-2.5 py-1">
                  Check Status
                </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Charts -->
        <section class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold">Occupancy by Shelter</h2>
                </div>
                <div class="h-72 bg-slate-100 flex items-center justify-center text-slate-500">
                    Chart Placeholder
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-200">
                    <h2 class="text-lg font-semibold">Capacity by Shelter Type</h2>
                </div>
                <div class="h-72 bg-slate-100 flex items-center justify-center text-slate-500">
                    Chart Placeholder
                </div>
            </div>
        </section>

        <!-- Detailed Table -->
        <section class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 px-5 py-4 border-b border-slate-200">
                <div>
                    <h2 class="text-lg font-semibold">Shelter Details</h2>
                    <p class="text-sm text-slate-500 mt-1">Operational shelter status and capacity</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button class="rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-3 py-2">
                        Near Capacity Only
                    </button>
                    <button class="rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-3 py-2">
                        Issues Only
                    </button>
                    <button class="rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium px-3 py-2">
                        Export
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-600">
                        <th class="px-4 py-3 font-semibold">Shelter</th>
                        <th class="px-4 py-3 font-semibold">Municipality</th>
                        <th class="px-4 py-3 font-semibold">Type</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold text-right">Pop</th>
                        <th class="px-4 py-3 font-semibold text-right">Capacity</th>
                        <th class="px-4 py-3 font-semibold text-right">% Full</th>
                        <th class="px-4 py-3 font-semibold text-right">Available</th>
                        <th class="px-4 py-3 font-semibold">Issues</th>
                        <th class="px-4 py-3 font-semibold">Last Update</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900">Auburndale High School</td>
                        <td class="px-4 py-3">Auburndale</td>
                        <td class="px-4 py-3">General Population</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-1">Open</span>
                        </td>
                        <td class="px-4 py-3 text-right">1,102</td>
                        <td class="px-4 py-3 text-right">1,445</td>
                        <td class="px-4 py-3 text-right font-semibold">76%</td>
                        <td class="px-4 py-3 text-right">343</td>
                        <td class="px-4 py-3">None</td>
                        <td class="px-4 py-3">07:15</td>
                    </tr>

                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900">Bartow High School Cafeteria</td>
                        <td class="px-4 py-3">Bartow</td>
                        <td class="px-4 py-3">Special Needs</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-1">Near Capacity</span>
                        </td>
                        <td class="px-4 py-3 text-right">421</td>
                        <td class="px-4 py-3 text-right">498</td>
                        <td class="px-4 py-3 text-right font-semibold">85%</td>
                        <td class="px-4 py-3 text-right">77</td>
                        <td class="px-4 py-3">Staffing</td>
                        <td class="px-4 py-3">07:12</td>
                    </tr>

                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900">Caldwell Elementary</td>
                        <td class="px-4 py-3">Lakeland</td>
                        <td class="px-4 py-3">General Population</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full bg-sky-100 text-sky-800 text-xs font-semibold px-2.5 py-1">Standby</span>
                        </td>
                        <td class="px-4 py-3 text-right">0</td>
                        <td class="px-4 py-3 text-right">263</td>
                        <td class="px-4 py-3 text-right font-semibold">0%</td>
                        <td class="px-4 py-3 text-right">263</td>
                        <td class="px-4 py-3">None</td>
                        <td class="px-4 py-3">06:58</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

    </main>
</div>
</body>
</html>