@extends('layouts.guest')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-2xl">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-sky-600 mb-4">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A24.626 24.626 0 0 1 12 20.904a24.626 24.626 0 0 1 8.231-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658 8.09M4.26 10.147a50.636 50.636 0 0 1 2.658-8.09m0 0a50.717 50.717 0 0 1 11.318-2.741M6.064 10.147a50.717 50.717 0 0 1 11.318 2.741M12 20.904c-2.583-1.564-4.5-3.566-5.7-5.81a24.626 24.626 0 0 1 11.4 0c-1.2 2.244-3.117 4.246-5.7 5.81Z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Create an Intern Account</h1>
            <p class="mt-2 text-sm text-gray-600">Register to apply for internship programs</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8">
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1.5">First Name</label>
                        <input id="first_name" type="text" name="first_name" value="{{ old('first_name') }}" required
                               class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition">
                        @error('first_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1.5">Last Name</label>
                        <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required
                               class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition">
                        @error('last_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition">
                    @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <input id="password" type="password" name="password" required
                               class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition">
                        @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition">
                    </div>
                </div>

                <hr class="border-gray-200">
                <p class="text-sm font-semibold text-gray-700">Academic Information</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="student_number" class="block text-sm font-medium text-gray-700 mb-1.5">Student Number</label>
                        <input id="student_number" type="text" name="student_number" value="{{ old('student_number') }}" required
                               class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition">
                        @error('student_number')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="year_level" class="block text-sm font-medium text-gray-700 mb-1.5">Year Level</label>
                        <select id="year_level" name="year_level" required
                                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition">
                            <option value="">Select year</option>
                            @for ($i = 1; $i <= 6; $i++)<option value="{{ $i }}" @selected(old('year_level') == $i)>{{ $i }}</option>@endfor
                        </select>
                        @error('year_level')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="school" class="block text-sm font-medium text-gray-700 mb-1.5">School</label>
                        <input id="school" type="text" name="school" value="{{ old('school') }}" required
                               class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition">
                        @error('school')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="course" class="block text-sm font-medium text-gray-700 mb-1.5">Course</label>
                        <input id="course" type="text" name="course" value="{{ old('course') }}" required
                               class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition">
                        @error('course')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number (optional)</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition">
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">Address (optional)</label>
                    <textarea id="address" name="address" rows="2"
                              class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition">{{ old('address') }}</textarea>
                </div>

                <div>
                    <label for="emergency_contact" class="block text-sm font-medium text-gray-700 mb-1.5">Emergency Contact (optional)</label>
                    <input id="emergency_contact" type="text" name="emergency_contact" value="{{ old('emergency_contact') }}"
                           class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 outline-none transition"
                           placeholder="Name and phone number">
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 focus:ring-2 focus:ring-sky-500/20 transition">
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Already have an account? <a href="{{ route('login') }}" class="font-semibold text-sky-600 hover:text-sky-700">Sign in here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
