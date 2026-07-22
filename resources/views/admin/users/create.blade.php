<x-layouts.app :page-title="'Create User'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create User</h1>
                <p class="mt-1 text-sm text-gray-600">Add a new user account to the system.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4" id="userForm">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                    <p class="mt-1 text-xs text-gray-500">Minimum 8 characters.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role_id" id="role_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required onchange="toggleSupervisorFields()">
                            <option value="">Select a role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm" required>
                            <option value="Active" @selected(old('status', 'Active') === 'Active')>Active</option>
                            <option value="Inactive" @selected(old('status') === 'Inactive')>Inactive</option>
                        </select>
                    </div>
                </div>
                <div id="supervisorFields" class="grid grid-cols-1 sm:grid-cols-2 gap-4" style="display: none;">
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Department (Supervisor only)</label>
                        <select name="department_id" id="department_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                            <option value="">Select a department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position (Supervisor only)</label>
                        <input type="text" name="position" id="position" value="{{ old('position') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSupervisorFields() {
            const roleSelect = document.getElementById('role_id');
            const selectedText = roleSelect.options[roleSelect.selectedIndex].text;
            const supervisorFields = document.getElementById('supervisorFields');
            supervisorFields.style.display = selectedText === 'Supervisor' ? 'grid' : 'none';
        }
        document.addEventListener('DOMContentLoaded', toggleSupervisorFields);
    </script>
</x-layouts.app>
