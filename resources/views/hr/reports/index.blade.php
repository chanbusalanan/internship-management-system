<x-layouts.app :page-title="'Reports'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reports</h1>
            <p class="mt-1 text-sm text-gray-600">Internship program summary and overview.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Total Interns</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalInterns }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Total Assignments</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalAssignments }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Active</p>
                <p class="text-2xl font-bold text-teal-600 mt-1">{{ $activeAssignments }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Completed</p>
                <p class="text-2xl font-bold text-gray-600 mt-1">{{ $completedAssignments }}</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <p class="text-sm font-medium text-gray-500">Total Evaluations</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalEvaluations }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">All Assignments</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intern</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supervisor</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hours</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($assignments as $assignment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assignment->intern?->user?->full_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assignment->department?->department_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assignment->supervisor?->user?->full_name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assignment->completed_hours }} / {{ $assignment->required_hours }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $colors = ['Active' => 'bg-teal-100 text-teal-800', 'Completed' => 'bg-gray-100 text-gray-800'];
                                        $color = $colors[$assignment->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }}">{{ $assignment->status }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('hr.assignments.show', $assignment) }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">No assignments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $assignments->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
