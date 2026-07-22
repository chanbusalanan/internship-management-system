<x-layouts.app :page-title="'Application Details'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('hr.applications.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Application Details</h1>
                <p class="mt-1 text-sm text-gray-600">Submitted on {{ $application->application_date->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Intern Information</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->intern?->user?->full_name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Student Number</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->intern?->student_number ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">School</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->intern?->school ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Course</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->intern?->course ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Year Level</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->intern?->year_level ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $application->intern?->user?->email ?? 'N/A' }}</dd>
                </div>
            </dl>

            <div class="mt-6 flex items-center gap-4 border-t border-gray-200 pt-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    @php
                        $colors = ['Pending' => 'bg-amber-100 text-amber-800', 'Approved' => 'bg-emerald-100 text-emerald-800', 'Rejected' => 'bg-red-100 text-red-800'];
                        $color = $colors[$application->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }}">{{ $application->status }}</span>
                </div>
                @if ($application->status === 'Pending')
                    <div class="flex gap-2 ml-auto">
                        <form action="{{ route('hr.applications.approve', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                Approve
                            </button>
                        </form>
                        <form action="{{ route('hr.applications.reject', $application) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                                Reject
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            @if ($application->remarks)
                <div class="mt-4 rounded-lg bg-gray-50 border border-gray-200 px-4 py-3">
                    <p class="text-sm font-medium text-gray-700">Remarks</p>
                    <p class="mt-1 text-sm text-gray-600">{{ $application->remarks }}</p>
                </div>
            @endif
        </div>

        @if ($application->assignment)
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Assignment Information</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Department</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $application->assignment->department?->department_name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Supervisor</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $application->assignment->supervisor?->user?->full_name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            @php
                                $asgColors = ['Active' => 'bg-teal-100 text-teal-800', 'Completed' => 'bg-gray-100 text-gray-800'];
                                $asgColor = $asgColors[$application->assignment->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $asgColor }}">{{ $application->assignment->status }}</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $application->assignment->start_date->format('M d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">End Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $application->assignment->end_date->format('M d, Y') }}</dd>
                    </div>
                </dl>
                <div class="mt-4">
                    <a href="{{ route('hr.assignments.show', $application->assignment) }}" class="inline-flex items-center gap-2 text-sm font-medium text-sky-600 hover:text-sky-700">
                        View Assignment Details
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                    </a>
                </div>
            </div>
        @elseif ($application->status === 'Approved')
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Assignment</h2>
                        <p class="mt-1 text-sm text-gray-600">This application is approved but no assignment has been created yet.</p>
                    </div>
                    <a href="{{ route('hr.assignments.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Assign Intern
                    </a>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Submitted Documents</h2>
            @if ($application->submissions->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requirement</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($application->submissions as $submission)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $submission->requirement?->requirement_name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $submission->original_filename }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $colors = ['Pending' => 'bg-amber-100 text-amber-800', 'Approved' => 'bg-emerald-100 text-emerald-800', 'Rejected' => 'bg-red-100 text-red-800'];
                                            $color = $colors[$submission->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }}">{{ $submission->status }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $submission->remarks ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('hr.submissions.show', $submission) }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">Review</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-gray-500 py-6 text-center">No documents submitted yet.</p>
            @endif
        </div>
    </div>
</x-layouts.app>
