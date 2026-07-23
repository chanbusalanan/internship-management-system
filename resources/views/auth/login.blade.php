@extends('layouts.guest')
@section('content')
<div class="w-full max-w-6xl overflow-hidden rounded-[32px] border border-white/70 bg-white/80 shadow-[0_35px_90px_-25px_rgba(15,23,42,0.35)] backdrop-blur-xl">
    <div class="grid lg:grid-cols-[1.05fr_0.95fr]">
        <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-sky-900 p-8 text-white sm:p-10 lg:p-12">
           
            <h1 class="mt-6 text-3xl font-semibold tracking-tight sm:text-4xl">Track internships with clarity and confidence.</h1>
            <p class="mt-4 max-w-xl text-sm leading-7 text-slate-300 sm:text-base">Give interns, supervisors, and HR one polished workspace to manage applications, submissions, evaluations, and announcements.</p>

            <div class="mt-8 space-y-3 text-sm text-slate-200">
                <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/10 px-4 py-3">
                    <svg class="h-5 w-5 text-sky-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    <span>Unified dashboards for every role</span>
                </div>
                <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/10 px-4 py-3">
                    <svg class="h-5 w-5 text-sky-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                    <span>Faster document review and approvals</span>
                </div>
                <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/10 px-4 py-3">
                    <svg class="h-5 w-5 text-sky-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    <span>Clear progress tracking for every internship</span>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8 lg:p-10">
            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-600 text-white shadow-lg shadow-sky-600/20">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A24.626 24.626 0 0 1 12 20.904a24.626 24.626 0 0 1 8.231-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658 8.09M4.26 10.147a50.636 50.636 0 0 1 2.658-8.09m0 0a50.717 50.717 0 0 1 11.318-2.741M6.064 10.147a50.717 50.717 0 0 1 11.318 2.741M12 20.904c-2.583-1.564-4.5-3.566-5.7-5.81a24.626 24.626 0 0 1 11.4 0c-1.2 2.244-3.117 4.246-5.7 5.81Z"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Welcome back</h2>
                    <p class="text-sm text-slate-500">Sign in to continue your internship workspace</p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10"
                           placeholder="you@example.com">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10"
                           placeholder="Enter your password">
                    @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                    Remember me
                </label>

                <button type="submit"
                        class="w-full rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-600/20 transition hover:bg-sky-700">
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-slate-600">Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-sky-600 hover:text-sky-700">Register here</a></p>
            </div>

            <div class="mt-6 rounded-2xl border border-sky-100 bg-sky-50/80 p-4 text-sm text-sky-800">
                <p class="mb-2 font-semibold">Demo Accounts</p>
                <div class="space-y-1 text-sm text-sky-700">
                    <p>Admin: admin@ims.test / password</p>
                    <p>HR: hr@ims.test / password</p>
                    <p>Supervisor: supervisor accounts available</p>
                    <p>Intern: intern accounts available</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
