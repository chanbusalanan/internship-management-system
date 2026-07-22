<x-layouts.app :page-title="'Document Review'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('hr.submissions.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Document Review</h1>
                <p class="mt-1 text-sm text-gray-600">Review the submitted document and take action.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Intern</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $submission->application?->intern?->user?->full_name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Requirement</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $submission->requirement?->requirement_name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">File Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $submission->original_filename }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        @php
                            $colors = ['Pending' => 'bg-amber-100 text-amber-800', 'Approved' => 'bg-emerald-100 text-emerald-800', 'Rejected' => 'bg-red-100 text-red-800'];
                            $color = $colors[$submission->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }}">{{ $submission->status }}</span>
                    </dd>
                </div>
                @if ($submission->reviewed_at)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Reviewed By</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $submission->reviewer?->full_name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Reviewed At</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $submission->reviewed_at->format('M d, Y g:i A') }}</dd>
                    </div>
                @endif
            </dl>

            <div class="mt-6 border-t border-gray-200 pt-4">
                <a href="{{ route('hr.submissions.download', $submission) }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Download Document
                </a>
            </div>
        </div>

        @if ($submission->status === 'Pending')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Approve Document</h2>
                    <form action="{{ route('hr.submissions.approve', $submission) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label for="approve_remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks (optional)</label>
                            <textarea name="remarks" id="approve_remarks" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" placeholder="Add any remarks about this approval..."></textarea>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                            Approve Document
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Reject Document</h2>
                    <form action="{{ route('hr.submissions.reject', $submission) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label for="reject_remarks" class="block text-sm font-medium text-gray-700 mb-1">Reason for rejection</label>
                            <textarea name="remarks" id="reject_remarks" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" placeholder="Explain why the document is being rejected..." required></textarea>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                            Reject Document
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Review Remarks</h2>
                <p class="text-sm text-gray-600">{{ $submission->remarks ?? 'No remarks provided.' }}</p>
            </div>
        @endif
    </div>
</x-layouts.app>
