<x-layouts.app :page-title="'Create Evaluation'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('supervisor.evaluations.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Evaluation</h1>
                <p class="mt-1 text-sm text-gray-600">Evaluate {{ $assignment->intern?->user?->full_name ?? 'intern' }}'s performance.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('supervisor.evaluations.store', $assignment) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="score" class="block text-sm font-medium text-gray-700 mb-1">Score (0-5)</label>
                        <input type="number" name="score" id="score" step="0.01" min="0" max="5" value="{{ old('score') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                        <p class="mt-1 text-xs text-gray-500">Enter a score between 0.00 and 5.00.</p>
                    </div>
                    <div>
                        <label for="evaluation_date" class="block text-sm font-medium text-gray-700 mb-1">Evaluation Date</label>
                        <input type="date" name="evaluation_date" id="evaluation_date" value="{{ old('evaluation_date', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                    </div>
                </div>
                <div>
                    <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                    <textarea name="remarks" id="remarks" rows="5" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" placeholder="Provide detailed feedback about the intern's performance...">{{ old('remarks') }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Submit Evaluation
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
