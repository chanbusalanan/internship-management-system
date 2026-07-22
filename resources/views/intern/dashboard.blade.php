<x-layouts.app :page-title="'Dashboard'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600">Welcome back, {{ auth()->user()->first_name }}. Here's your internship overview.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-sky-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-500">Application</p>
                        <p class="text-lg font-semibold text-gray-900 truncate">{{ $stats['application_status'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-teal-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.29-.143-6.379-.42c-1.085-.144-1.871-1.086-1.871-2.18v-4.25"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-500">Assignment</p>
                        <p class="text-lg font-semibold text-gray-900 truncate">{{ $stats['assignment_status'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-violet-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-500">Hours Completed</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $stats['completed_hours'] }} / {{ $stats['required_hours'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-500">Evaluations</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $stats['evaluations'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Total Logs</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_logs'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Pending Logs</p>
                <p class="text-2xl font-bold text-amber-600 mt-1">{{ $stats['pending_logs'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Approved Logs</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $stats['approved_logs'] }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Recent Daily Logs</h2>
                    <a href="{{ route('intern.logs.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">View all</a>
                </div>
                @if ($recentLogs->isNotEmpty())
                    <ul class="divide-y divide-gray-200">
                        @foreach ($recentLogs as $log)
                            <li class="py-3 flex items-center justify-between">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $log->log_date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $log->activity_description }}</p>
                                </div>
                                <a href="{{ route('intern.logs.show', $log) }}" class="text-sm font-medium text-sky-600 hover:text-sky-700 shrink-0 ml-4">View</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 py-6 text-center">No daily logs submitted yet.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Announcements</h2>
                    <a href="{{ route('intern.announcements.index') }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">View all</a>
                </div>
                @if ($announcements->isNotEmpty())
                    <ul class="divide-y divide-gray-200">
                        @foreach ($announcements as $announcement)
                            <li class="py-3">
                                <a href="{{ route('intern.announcements.show', $announcement) }}" class="block hover:bg-gray-50 -mx-2 px-2 rounded-lg transition">
                                    <p class="text-sm font-medium text-gray-900">{{ $announcement->title }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $announcement->created_at->format('M d, Y') }}</p>
                                </a>
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
