<x-layouts.app :page-title="'HR Dashboard'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">HR Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600">Manage applications, assignments, and announcements.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_applications'] }}</p>
                        <p class="text-sm text-gray-500">Pending Applications</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['approved_applications'] }}</p>
                        <p class="text-sm text-gray-500">Approved Applications</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-red-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['rejected_applications'] }}</p>
                        <p class="text-sm text-gray-500">Rejected Applications</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-sky-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_submissions'] }}</p>
                        <p class="text-sm text-gray-500">Pending Documents</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-teal-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.29-.143-6.379-.42c-1.085-.144-1.871-1.086-1.871-2.18v-4.25"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['active_assignments'] }}</p>
                        <p class="text-sm text-gray-500">Active Assignments</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_assignments'] }}</p>
                        <p class="text-sm text-gray-500">Completed Assignments</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Applications</h2>
                    <a href="{{ route('hr.applications.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">View all</a>
                </div>
                @if ($recentApplications->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intern</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($recentApplications as $application)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $application->intern?->user?->full_name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $application->application_date->format('M d, Y') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @php
                                                $colors = ['Pending' => 'bg-amber-100 text-amber-800', 'Approved' => 'bg-emerald-100 text-emerald-800', 'Rejected' => 'bg-red-100 text-red-800'];
                                                $color = $colors[$application->status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }}">{{ $application->status }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-right">
                                            <a href="{{ route('hr.applications.show', $application) }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-gray-500 py-6 text-center">No applications yet.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Announcements</h2>
                    <a href="{{ route('hr.announcements.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">View all</a>
                </div>
                @if ($announcements->isNotEmpty())
                    <ul class="divide-y divide-gray-200">
                        @foreach ($announcements as $announcement)
                            <li class="py-3">
                                <p class="text-sm font-medium text-gray-900">{{ $announcement->title }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $announcement->created_at->format('M d, Y') }}</p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 py-6 text-center">No announcements available.</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
