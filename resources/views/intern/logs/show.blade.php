<x-layouts.app :page-title="'Log Details'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('intern.logs.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Log Details</h1>
                <p class="mt-1 text-sm text-gray-600">{{ $log->log_date->format('l, M d, Y') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $log->log_date->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Time In</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($log->time_in)->format('g:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Time Out</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($log->time_out)->format('g:i A') }}</dd>
                </div>
            </dl>

            <div class="mt-6">
                <dt class="text-sm font-medium text-gray-500">Activity Description</dt>
                <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $log->activity_description }}</dd>
            </div>

            <div class="mt-6 flex items-center gap-4 border-t border-gray-200 pt-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    @php
                        $colors = ['Pending' => 'bg-amber-100 text-amber-800', 'Approved' => 'bg-emerald-100 text-emerald-800', 'Rejected' => 'bg-red-100 text-red-800'];
                        $color = $colors[$log->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }}">{{ $log->status }}</span>
                </div>
                @if ($log->reviewed_at)
                    <div>
                        <p class="text-sm font-medium text-gray-500">Reviewed At</p>
                        <p class="mt-1 text-sm text-gray-900">{{ $log->reviewed_at->format('M d, Y g:i A') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
