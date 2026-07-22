<x-layouts.app :page-title="'My Interns'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Interns</h1>
            <p class="mt-1 text-sm text-gray-600">View your assigned interns and their progress.</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intern</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assignment->start_date->format('M d, Y') }} — {{ $assignment->end_date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assignment->completed_hours }} / {{ $assignment->required_hours }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $colors = ['Active' => 'bg-teal-100 text-teal-800', 'Completed' => 'bg-gray-100 text-gray-800'];
                                        $color = $colors[$assignment->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $color }}">{{ $assignment->status }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('supervisor.interns.show', $assignment) }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">No assigned interns found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($assignments instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $assignments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
