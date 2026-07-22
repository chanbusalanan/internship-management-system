<x-layouts.app :page-title="'Submit Daily Log'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('intern.logs.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Submit Daily Log</h1>
                <p class="mt-1 text-sm text-gray-600">Record your daily internship activities.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('intern.logs.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="log_date" class="block text-sm font-medium text-gray-700 mb-1">Log Date</label>
                        <input type="date" name="log_date" id="log_date" value="{{ old('log_date', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="time_in" class="block text-sm font-medium text-gray-700 mb-1">Time In</label>
                        <input type="time" name="time_in" id="time_in" value="{{ old('time_in') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="time_out" class="block text-sm font-medium text-gray-700 mb-1">Time Out</label>
                        <input type="time" name="time_out" id="time_out" value="{{ old('time_out') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                    </div>
                </div>
                <div>
                    <label for="activity_description" class="block text-sm font-medium text-gray-700 mb-1">Activity Description</label>
                    <textarea name="activity_description" id="activity_description" rows="5" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required placeholder="Describe the tasks and activities you completed today...">{{ old('activity_description') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Minimum 10 characters.</p>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/></svg>
                        Submit Log
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
