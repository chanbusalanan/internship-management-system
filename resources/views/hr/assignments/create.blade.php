<x-layouts.app :page-title="'Create Assignment'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('hr.assignments.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Assignment</h1>
                <p class="mt-1 text-sm text-gray-600">Assign an approved intern to a department and supervisor.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            @if ($approvedApplications->isNotEmpty())
                <form action="{{ route('hr.assignments.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="application_id" class="block text-sm font-medium text-gray-700 mb-1">Intern / Application</label>
                        <select name="application_id" id="application_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                            <option value="">Select an approved application</option>
                            @foreach ($approvedApplications as $application)
                                <option value="{{ $application->id }}" @selected(old('application_id') == $application->id)>{{ $application->intern?->user?->full_name ?? 'Unknown' }} — {{ $application->application_date->format('M d, Y') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <select name="department_id" id="department_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                                <option value="">Select a department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="supervisor_id" class="block text-sm font-medium text-gray-700 mb-1">Supervisor</label>
                            <select name="supervisor_id" id="supervisor_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                                <option value="">Select a supervisor</option>
                                @foreach ($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}" @selected(old('supervisor_id') == $supervisor->id)>{{ $supervisor->user?->full_name ?? 'Unknown' }} — {{ $supervisor->department?->department_name ?? 'No Dept' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="required_hours" class="block text-sm font-medium text-gray-700 mb-1">Required Hours</label>
                            <input type="number" name="required_hours" id="required_hours" min="1" value="{{ old('required_hours', 500) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            Create Assignment
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    <p class="text-sm text-gray-500">There are no approved applications without assignments.</p>
                    <a href="{{ route('hr.applications.index') }}" class="mt-4 inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                        View Applications
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
