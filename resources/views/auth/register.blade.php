@extends('layouts.guest')
@section('content')
<div class="w-full max-w-5xl overflow-hidden rounded-[32px] border border-white/70 bg-white/80 shadow-[0_35px_90px_-25px_rgba(15,23,42,0.35)] backdrop-blur-xl">
    <div class="grid lg:grid-cols-[0.9fr_1.1fr]">
        <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-sky-900 p-8 text-white sm:p-10 lg:p-12">
            <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1 text-sm font-medium text-sky-100">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                Create your intern profile
            </div>
            <h1 class="mt-6 text-3xl font-semibold tracking-tight sm:text-4xl">Create an Intern Account</h1>
            <p class="mt-4 max-w-xl text-sm leading-7 text-slate-300 sm:text-base">Apply for opportunities, upload requirements, and keep your profile up to date in one streamlined experience.</p>

            <div class="mt-8 rounded-2xl border border-white/10 bg-white/10 p-4 text-sm text-slate-200">
                <p class="font-semibold text-white">What you can do</p>
                <ul class="mt-3 space-y-2 text-sm text-slate-300">
                    <li>• Track internship applications and statuses</li>
                    <li>• Upload documents securely</li>
                    <li>• Stay aligned with supervisors and HR</li>
                </ul>
            </div>
        </div>

        <div class="p-6 sm:p-8 lg:p-10">
            <div class="mb-6 flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-600 text-white shadow-lg shadow-sky-600/20">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A24.626 24.626 0 0 1 12 20.904a24.626 24.626 0 0 1 8.231-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658 8.09M4.26 10.147a50.636 50.636 0 0 1 2.658-8.09m0 0a50.717 50.717 0 0 1 11.318-2.741M6.064 10.147a50.717 50.717 0 0 1 11.318 2.741M12 20.904c-2.583-1.564-4.5-3.566-5.7-5.81a24.626 24.626 0 0 1 11.4 0c-1.2 2.244-3.117 4.246-5.7 5.81Z"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Create an account</h2>
                    <p class="text-sm text-slate-500">Join the internship management system</p>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="first_name" class="mb-2 block text-sm font-medium text-slate-700">First Name</label>
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10">
                        @error('first_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="last_name" class="mb-2 block text-sm font-medium text-slate-700">Last Name</label>
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10">
                        @error('last_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                        <input id="password" type="password" name="password" required
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10">
                        @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10">
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4">
                    <p class="mb-3 text-sm font-semibold text-slate-700">Academic Information</p>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="student_number" class="mb-2 block text-sm font-medium text-slate-700">Student Number</label>
                            <input id="student_number" type="text" name="student_number" value="{{ old('student_number') }}" required
                                   class="w-full rounded-2xl border border-slate-200 bg-white px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10">
                            @error('student_number')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="year_level" class="mb-2 block text-sm font-medium text-slate-700">Year Level</label>
                            <select id="year_level" name="year_level" required
                                    class="w-full rounded-2xl border border-slate-200 bg-white px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10">
                                <option value="">Select year</option>
                                @for ($i = 1; $i <= 6; $i++)<option value="{{ $i }}" @selected(old('year_level') == $i)>{{ $i }}</option>@endfor
                            </select>
                            @error('year_level')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="school" class="mb-2 block text-sm font-medium text-slate-700">School</label>
                            <input id="school" type="text" name="school" value="{{ old('school') }}" required
                                   class="w-full rounded-2xl border border-slate-200 bg-white px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10">
                            @error('school')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="course" class="mb-2 block text-sm font-medium text-slate-700">Course</label>
                            <input id="course" type="text" name="course" value="{{ old('course') }}" required
                                   class="w-full rounded-2xl border border-slate-200 bg-white px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10">
                            @error('course')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-medium text-slate-700">Phone Number (optional)</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10">
                </div>

                <div>
                    <label for="address" class="mb-2 block text-sm font-medium text-slate-700">Address (optional)</label>
                    <textarea id="address" name="address" rows="2"
                              class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10">{{ old('address') }}</textarea>
                </div>

                <div>
                    <label for="emergency_contact" class="mb-2 block text-sm font-medium text-slate-700">Emergency Contact (optional)</label>
                    <input id="emergency_contact" type="text" name="emergency_contact" value="{{ old('emergency_contact') }}"
                           class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-3.5 py-2.75 text-sm text-slate-900 outline-none transition focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-500/10"
                           placeholder="Name and phone number">
                </div>

                <button type="submit"
                        class="w-full rounded-2xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-600/20 transition hover:bg-sky-700">
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-slate-600">Already have an account? <a href="{{ route('login') }}" class="font-semibold text-sky-600 hover:text-sky-700">Sign in here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
