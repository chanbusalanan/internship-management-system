<x-layouts.app :page-title="'Evaluation Details'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('supervisor.evaluations.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Evaluation Details</h1>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Intern</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->assignment?->intern?->user?->full_name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->evaluation_date->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Score</dt>
                    <dd class="mt-1">
                        <span class="text-2xl font-bold text-gray-900">{{ $evaluation->score }}</span>
                        <span class="text-sm text-gray-400">/ 5.00</span>
                    </dd>
                </div>
            </dl>

            <div class="mt-6 border-t border-gray-200 pt-4">
                <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $evaluation->remarks ?? 'No remarks provided.' }}</dd>
            </div>
        </div>
    </div>
</x-layouts.app>
