<x-layouts.app :page-title="'Intern Details'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('supervisor.interns.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $assignment->intern?->user?->full_name ?? 'Intern Details' }}</h1>
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
                <div>
                    <dt class="text-sm font-medium text-gray-500">Course</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $assignment->intern?->course ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Department</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $assignment->department?->department_name ?? 'N/A' }}</dd>
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

            @if ($assignment->status === 'Active')
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <a href="{{ route('supervisor.evaluations.create', $assignment) }}" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
                        Add Evaluation
                    </a>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Daily Logs</h2>
                @if ($assignment->logs->isNotEmpty())
                    <ul class="divide-y divide-gray-200">
                        @foreach ($assignment->logs->sortByDesc('log_date')->take(10) as $log)
                            <li class="py-3 flex items-center justify-between">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $log->log_date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $log->activity_description }}</p>
                                </div>
                                @php
                                    $colors = ['Pending' => 'bg-amber-100 text-amber-800', 'Approved' => 'bg-emerald-100 text-emerald-800', 'Rejected' => 'bg-red-100 text-red-800'];
                                    $color = $colors[$log->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }} shrink-0 ml-4">{{ $log->status }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 py-6 text-center">No daily logs submitted yet.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Evaluations</h2>
                @if ($assignment->evaluations->isNotEmpty())
                    <ul class="divide-y divide-gray-200">
                        @foreach ($assignment->evaluations->sortByDesc('evaluation_date')->take(10) as $evaluation)
                            <li class="py-3 flex items-center justify-between">
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $evaluation->evaluation_date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $evaluation->remarks ?? 'No remarks' }}</p>
                                </div>
                                <span class="text-sm font-semibold text-gray-900 shrink-0 ml-4">{{ $evaluation->score }}/5</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500 py-6 text-center">No evaluations submitted yet.</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
