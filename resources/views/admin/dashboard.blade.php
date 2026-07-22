<x-layouts.app :page-title="isset($pageTitle) ? $pageTitle : 'Dashboard'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600">System overview and administrative controls</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-sky-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.676 0-5.216-.584-7.499-1.632l-.115-.044a4.125 4.125 0 0 0-.976-2.682M4.5 6.75h15M4.5 12h15m-15 5.25h6m-3.75 3v-3.375c0-.621.504-1.125 1.125-1.125h.375M15 12V8.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 7.5 3 8.004 3 8.625V12"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                        <p class="text-sm text-gray-500">Total Users</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-emerald-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['active_users'] }}</p>
                        <p class="text-sm text-gray-500">Active Users</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-amber-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h7.5m-7.5 0a2.25 2.25 0 0 0-2.25 2.25v11.25A2.25 2.25 0 0 0 4.5 18.75h7.5m-7.5-15v15m7.5-15h7.5m-7.5 0a2.25 2.25 0 0 0-2.25 2.25v11.25A2.25 2.25 0 0 0 11.25 18.75h7.5m-7.5-15v15"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_departments'] }}</p>
                        <p class="text-sm text-gray-500">Departments</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-violet-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A24.626 24.626 0 0 1 12 20.904a24.626 24.626 0 0 1 8.231-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658 8.09M4.26 10.147a50.636 50.636 0 0 1 2.658-8.09m0 0a50.717 50.717 0 0 1 11.318-2.741M6.064 10.147a50.717 50.717 0 0 1 11.318 2.741"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_interns'] }}</p>
                        <p class="text-sm text-gray-500">Interns</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-rose-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_supervisors'] }}</p>
                        <p class="text-sm text-gray-500">Supervisors</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-lg bg-teal-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.29-.143-6.379-.42c-1.085-.144-1.871-1.086-1.871-2.18v-4.25"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['active_assignments'] }}</p>
                        <p class="text-sm text-gray-500">Active Assignments</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                <div class="space-y-2">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3 hover:bg-gray-50 transition">
                        <span class="text-sm font-medium text-gray-700">Manage Users</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                    </a>
                    <a href="{{ route('admin.departments.index') }}" class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3 hover:bg-gray-50 transition">
                        <span class="text-sm font-medium text-gray-700">Manage Departments</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                    </a>
                    <a href="{{ route('admin.requirements.index') }}" class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3 hover:bg-gray-50 transition">
                        <span class="text-sm font-medium text-gray-700">Manage Requirements</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="flex items-center justify-between rounded-lg border border-gray-200 px-4 py-3 hover:bg-gray-50 transition">
                        <span class="text-sm font-medium text-gray-700">Manage Announcements</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
