<x-layouts.app :page-title="'My Evaluations'">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Evaluations</h1>
            <p class="mt-1 text-sm text-gray-600">Performance evaluations from your supervisor.</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            @if ($evaluations->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($evaluations as $evaluation)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $evaluation->evaluation_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-1">
                                            <span class="text-sm font-semibold text-gray-900">{{ $evaluation->score }}</span>
                                            <span class="text-xs text-gray-400">/ 5.00</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 max-w-xs">{{ $evaluation->remarks ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
                    <p class="text-sm text-gray-500">No evaluations have been submitted yet.</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
