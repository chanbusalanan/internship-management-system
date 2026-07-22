<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($pageTitle) ? $pageTitle . ' — ' : '' }}{{ config('app.name', 'Internship Management System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="min-h-full flex">
        @auth
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-800 text-white flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full" id="sidebar">
            <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-700">
                <div class="w-10 h-10 rounded-lg bg-sky-500 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A24.626 24.626 0 0 1 12 20.904a24.626 24.626 0 0 1 8.231-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658 8.09M4.26 10.147a50.636 50.636 0 0 1 2.658-8.09m0 0a50.717 50.717 0 0 1 11.318-2.741M6.064 10.147a50.717 50.717 0 0 1 11.318 2.741M12 20.904c-2.583-1.564-4.5-3.566-5.7-5.81a24.626 24.626 0 0 1 11.4 0c-1.2 2.244-3.117 4.246-5.7 5.81Z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold leading-tight truncate">Internship MS</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->role->role_name }}</p>
                </div>
            </div>

            <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-1">
                @php
                    $role = auth()->user()->role->role_name;
                    $currentRoute = request()->route()->getName();
                    $navItems = [];
                    if ($role === 'Intern') {
                        $navItems = [
                            ['route' => 'intern.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
                            ['route' => 'intern.profile.edit', 'label' => 'My Profile', 'icon' => 'user'],
                            ['route' => 'intern.applications.index', 'label' => 'Applications', 'icon' => 'document'],
                            ['route' => 'intern.logs.index', 'label' => 'Daily Logs', 'icon' => 'clock'],
                            ['route' => 'intern.evaluations.index', 'label' => 'Evaluations', 'icon' => 'star'],
                            ['route' => 'intern.announcements.index', 'label' => 'Announcements', 'icon' => 'speaker'],
                        ];
                    } elseif ($role === 'HR') {
                        $navItems = [
                            ['route' => 'hr.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
                            ['route' => 'hr.applications.index', 'label' => 'Applications', 'icon' => 'document'],
                            ['route' => 'hr.submissions.index', 'label' => 'Documents', 'icon' => 'upload'],
                            ['route' => 'hr.assignments.index', 'label' => 'Assignments', 'icon' => 'briefcase'],
                            ['route' => 'hr.reports.index', 'label' => 'Reports', 'icon' => 'chart'],
                            ['route' => 'hr.announcements.index', 'label' => 'Announcements', 'icon' => 'speaker'],
                        ];
                    } elseif ($role === 'Supervisor') {
                        $navItems = [
                            ['route' => 'supervisor.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
                            ['route' => 'supervisor.interns.index', 'label' => 'My Interns', 'icon' => 'users'],
                            ['route' => 'supervisor.logs.index', 'label' => 'Daily Logs', 'icon' => 'clock'],
                            ['route' => 'supervisor.evaluations.index', 'label' => 'Evaluations', 'icon' => 'star'],
                            ['route' => 'supervisor.announcements.index', 'label' => 'Announcements', 'icon' => 'speaker'],
                        ];
                    } elseif ($role === 'Admin') {
                        $navItems = [
                            ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
                            ['route' => 'admin.users.index', 'label' => 'Users', 'icon' => 'users'],
                            ['route' => 'admin.departments.index', 'label' => 'Departments', 'icon' => 'building'],
                            ['route' => 'admin.requirements.index', 'label' => 'Requirements', 'icon' => 'document'],
                            ['route' => 'admin.announcements.index', 'label' => 'Announcements', 'icon' => 'speaker'],
                        ];
                    }
                @endphp

                @foreach ($navItems as $item)
                    @php
                        $isActive = str_starts_with($currentRoute, explode('.', $item['route'])[0] . '.' . explode('.', $item['route'])[1] . '.')
                            || $currentRoute === $item['route'];
                    @endphp
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $isActive ? 'bg-sky-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                        @switch($item['icon'])
                            @case('home')<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.5a.75.75 0 0 0 .75.75h4.5a.75.75 0 0 0 .75-.75V15a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 0 .75.75h4.5a.75.75 0 0 0 .75-.75V9.75M8.25 21h8.25"/></svg>@break
                            @case('user')<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>@break
                            @case('users')<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.115-.044a4.125 4.125 0 0 0-.976-2.682M4.5 6.75h15M4.5 12h15m-15 5.25h6m-3.75 3v-3.375c0-.621.504-1.125 1.125-1.125h.375M15 12V8.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 7.5 3 8.004 3 8.625V12"/></svg>@break
                            @case('document')<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>@break
                            @case('clock')<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>@break
                            @case('star')<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>@break
                            @case('speaker')<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.34 4.94c.09-.542.56-.94 1.11-.94h1.1c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>@break
                            @case('upload')<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>@break
                            @case('briefcase')<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.29-.143-6.379-.42c-1.085-.144-1.871-1.086-1.871-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m-9.75 0V6.515c0-.963.724-1.787 1.687-1.871a44.964 44.964 0 0 1 3.062-.157c1.029 0 2.04.054 3.062.157.963.084 1.687.908 1.687 1.871v.573m-9.75 0c0 .517.165.93.439 1.211.317.303.767.44 1.262.44h9.738c.495 0 .945-.137 1.262-.44.274-.28.439-.694.439-1.211"/></svg>@break
                            @case('chart')<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>@break
                            @case('building')<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h7.5m-7.5 0a2.25 2.25 0 0 0-2.25 2.25v11.25A2.25 2.25 0 0 0 4.5 18.75h7.5m-7.5-15v15m7.5-15h7.5m-7.5 0a2.25 2.25 0 0 0-2.25 2.25v11.25A2.25 2.25 0 0 0 11.25 18.75h7.5m-7.5-15v15m7.5-15a2.25 2.25 0 0 1 2.25 2.25v11.25a2.25 2.25 0 0 1-2.25 2.25h-7.5"/></svg>@break
                        @endswitch
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="px-3 py-4 border-t border-slate-700">
                <div class="flex items-center gap-3 px-3 py-2">
                    <div class="w-9 h-9 rounded-full bg-slate-600 flex items-center justify-center text-sm font-semibold shrink-0">
                        {{ strtoupper(auth()->user()->first_name[0] . auth()->user()->last_name[0]) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium truncate">{{ auth()->user()->full_name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 lg:ml-64 flex flex-col min-w-0">
            <header class="bg-white border-b border-gray-200 sticky top-0 z-30 lg:hidden">
                <div class="flex items-center justify-between px-4 py-3">
                    <button type="button" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                    </button>
                    <span class="font-semibold text-gray-800">Internship MS</span>
                    <div class="w-10"></div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @if (session('success'))
                    <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800 flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800 flex items-center gap-2">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                        <p class="font-medium mb-1">Please fix the following:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
        @endauth

        @guest
        {{ $slot }}
        @endguest
    </div>

    <script>
        document.addEventListener('click', function(e) {
            if (e.target.closest('#sidebar a')) {
                if (window.innerWidth < 1024) {
                    document.getElementById('sidebar').classList.add('-translate-x-full');
                }
            }
        });
    </script>
</body>
</html>
