<x-layouts.app :page-title="'Upload Document'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('intern.applications.show', $application) }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Upload Document</h1>
                <p class="mt-1 text-sm text-gray-600">Submit a required document for your application.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            @if ($availableRequirements->isNotEmpty())
                <form action="{{ route('intern.applications.submissions.store', $application) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="requirement_id" class="block text-sm font-medium text-gray-700 mb-1">Requirement</label>
                        <select name="requirement_id" id="requirement_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                            <option value="">Select a requirement</option>
                            @foreach ($availableRequirements as $requirement)
                                <option value="{{ $requirement->id }}" @selected(old('requirement_id') == $requirement->id)>{{ $requirement->requirement_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Document File</label>
                        <input type="file" name="file" id="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100" required>
                        <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, JPG, JPEG, PNG, DOC, DOCX. Max size: 5MB.</p>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                            Upload Document
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    <p class="text-sm text-gray-500">All required documents have been submitted for this application.</p>
                    <a href="{{ route('intern.applications.show', $application) }}" class="mt-4 inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                        Back to Application
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
