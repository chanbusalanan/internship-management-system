<x-layouts.app :page-title="'Applications'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Applications</h1>
            <p class="mt-1 text-sm text-gray-600">Review and manage internship applications.</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <form action="{{ route('hr.applications.index') }}" method="GET" class="flex items-center gap-3">
                <label for="status" class="text-sm font-medium text-gray-700">Filter by status:</label>
                <select name="status" id="status" class="rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="Pending" @selected(request('status') === 'Pending')>Pending</option>
                    <option value="Approved" @selected(request('status') === 'Approved')>Approved</option>
                    <option value="Rejected" @selected(request('status') === 'Rejected')>Rejected</option>
                </select>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    Apply
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intern</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documents</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($applications as $application)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $application->intern?->user?->full_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $application->application_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $application->submissions->count() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $colors = ['Pending' => 'bg-amber-100 text-amber-800', 'Approved' => 'bg-emerald-100 text-emerald-800', 'Rejected' => 'bg-red-100 text-red-800'];
                                        $color = $colors[$application->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }}">{{ $application->status }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('hr.applications.show', $application) }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">No applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
