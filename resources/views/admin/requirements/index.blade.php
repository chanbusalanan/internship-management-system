<x-layouts.app :page-title="'Requirements'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Requirements</h1>
            <p class="mt-1 text-sm text-gray-600">Manage internship document requirements.</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Add Requirement</h2>
            <form action="{{ route('admin.requirements.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label for="requirement_name" class="block text-sm font-medium text-gray-700 mb-1">Requirement Name</label>
                    <input type="text" name="requirement_name" id="requirement_name" value="{{ old('requirement_name') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                </div>
                <div class="flex items-center gap-2 pt-6">
                    <input type="checkbox" name="is_required" id="is_required" value="1" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500" @checked(old('is_required', true))>
                    <label for="is_required" class="text-sm font-medium text-gray-700">Required</label>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Add
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requirement</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Required</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submissions</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($requirements as $requirement)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $requirement->requirement_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $requirement->description ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($requirement->is_required)
                                        <span class="inline-flex items-center rounded-full bg-sky-100 px-2.5 py-0.5 text-xs font-medium text-sky-800">Required</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">Optional</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $requirement->submissions_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.requirements.edit', $requirement) }}" class="text-sm font-medium text-sky-600 hover:text-sky-700">Edit</a>
                                        <form action="{{ route('admin.requirements.destroy', $requirement) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this requirement?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">No requirements found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $requirements->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
