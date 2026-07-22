<x-layouts.app :page-title="'Assignment Details'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('hr.assignments.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Assignment Details</h1>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Intern Information</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $assignment->intern?->user?->full_name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Student Number</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $assignment->intern?->student_number ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">School</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $assignment->intern?->school ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Assignment Information</h2>
                @if ($assignment->status === 'Active')
                    <form action="{{ route('hr.assignments.complete', $assignment) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this assignment as completed?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-gray-600 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            Mark Complete
                        </button>
                    </form>
                @endif
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Department</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $assignment->department?->department_name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Supervisor</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $assignment->supervisor?->user?->full_name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1">
                        @php
                            $colors = ['Active' => 'bg-teal-100 text-teal-800', 'Completed' => 'bg-gray-100 text-gray-800'];
                            $color = $colors[$assignment->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }}">{{ $assignment->status }}</span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $assignment->start_date->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">End Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $assignment->end_date->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Hours</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $assignment->completed_hours }} / {{ $assignment->required_hours }}</dd>
                </div>
            </dl>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <p class="text-sm font-medium text-gray-500">Total Daily Logs</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $assignment->logs->count() }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <p class="text-sm font-medium text-gray-500">Total Evaluations</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $assignment->evaluations->count() }}</p>
            </div>
        </div>
    </div>
</x-layouts.app>
