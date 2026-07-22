<x-layouts.app :page-title="'Edit Requirement'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.requirements.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Requirement</h1>
                <p class="mt-1 text-sm text-gray-600">Update requirement information.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('admin.requirements.update', $requirement) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="requirement_name" class="block text-sm font-medium text-gray-700 mb-1">Requirement Name</label>
                    <input type="text" name="requirement_name" id="requirement_name" value="{{ old('requirement_name', $requirement->requirement_name) }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">{{ old('description', $requirement->description) }}</textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_required" id="is_required" value="1" class="rounded border-gray-300 text-sky-600 focus:ring-sky-500" @checked(old('is_required', $requirement->is_required))>
                    <label for="is_required" class="text-sm font-medium text-gray-700">Required for all applications</label>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Update Requirement
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
