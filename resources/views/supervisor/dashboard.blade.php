<x-layouts.app :page-title="'Supervisor Dashboard'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Supervisor Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600">Manage your assigned interns and review their daily logs.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-sky-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.676 0-5.216-.584-7.499-1.766l-.115-.044a4.125 4.125 0 0 0-.976-2.682M4.5 6.75h15M4.5 12h15m-15 5.25h6m-3.75 3v-3.375c0-.621.504-1.125 1.125-1.125h.375M15 12V8.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 7.5 3 8.004 3 8.625V12"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['assigned_interns'] }}</p>
                        <p class="text-sm text-gray-500">Assigned Interns</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_logs'] }}</p>
                        <p class="text-sm text-gray-500">Pending Logs</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['approved_logs'] }}</p>
                        <p class="text-sm text-gray-500">Approved Logs</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-violet-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_evaluations'] }}</p>
                        <p class="text-sm text-gray-500">Evaluations</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Pending Logs</h2>
                    <a href="{{ route('supervisor.logs.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">View all</a>
                </div>
                @if ($pendingLogs->isNotEmpty())
                    <ul class="divide-y divide-gray-200">
                        @foreach ($pendingLogs as $log)
                            <li class="py-3 flex items-center justify-between">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $log->assignment?->intern?->user?->full_name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">{{ $log->log_date->format('M d, Y') }} • {{ $log->activity_description }}</p>
                                </div>
                                <a href="{{ route('supervisor.logs.show', $log) }}" class="text-sm font-medium text-sky-600 hover:text-sky-700 shrink-0 ml-4">Review</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 py-6 text-center">No pending logs to review.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Announcements</h2>
                    <a href="{{ route('supervisor.announcements.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">View all</a>
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
