<x-layouts.app :page-title="'Application Details'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('intern.applications.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Application Details</h1>
                <p class="mt-1 text-sm text-gray-600">Submitted on {{ $application->application_date->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    @php
                        $colors = ['Pending' => 'bg-amber-100 text-amber-800', 'Approved' => 'bg-emerald-100 text-emerald-800', 'Rejected' => 'bg-red-100 text-red-800'];
                        $color = $colors[$application->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }}">{{ $application->status }}</span>
                </div>
                @if ($application->status === 'Approved' && ! $application->assignment)
                    <a href="{{ route('intern.submissions.create', $application) }}" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                        Upload Document
                    </a>
                @elseif ($application->status === 'Pending')
                    <a href="{{ route('intern.submissions.create', $application) }}" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                        Upload Document
                    </a>
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
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Department</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $application->assignment->department?->department_name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Supervisor</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $application->assignment->supervisor?->user?->full_name ?? 'N/A' }}</dd>
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
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($application->submissions as $submission)
                                <tr>
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
