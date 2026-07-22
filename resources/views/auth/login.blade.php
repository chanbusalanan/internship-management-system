@extends('layouts.guest')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-sky-600 mb-4">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A24.626 24.626 0 0 1 12 20.904a24.626 24.626 0 0 1 8.231-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658 8.09M4.26 10.147a50.636 50.636 0 0 1 2.658-8.09m0 0a50.717 50.717 0 0 1 11.318-2.741M6.064 10.147a50.717 50.717 0 0 1 11.318 2.741M12 20.904c-2.583-1.564-4.5-3.566-5.7-5.81a24.626 24.626 0 0 1 11.4 0c-1.2 2.244-3.117 4.246-5.7 5.81Z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Internship Management System</h1>
            <p class="mt-2 text-sm text-gray-600">Sign in to your account to continue</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition"
                           placeholder="you@example.com">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition"
                           placeholder="Enter your password">
                    @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500">
                        Remember me
                    </label>
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 focus:ring-2 focus:ring-sky-500/20 transition">
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="font-semibold text-sky-600 hover:text-sky-700">Register here</a></p>
            </div>
        </div>

        <div class="mt-6 rounded-lg bg-sky-50 border border-sky-100 p-4">
            <p class="text-xs text-sky-800 font-medium mb-2">Demo Accounts:</p>
            <div class="space-y-1 text-xs text-sky-700">
                <p>Admin: admin@ims.test / password</p>
                <p>HR: hr@ims.test / password</p>
                <p>Supervisor: supervisor accounts available</p>
                <p>Intern: intern accounts available</p>
            </div>
        </div>
    </div>
</div>
@endsection
