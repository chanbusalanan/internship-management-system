<x-layouts.app :page-title="'Announcement'">
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('intern.announcements.index') }}" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Announcement</h1>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900">{{ $announcement->title }}</h2>
            <div class="mt-3 flex items-center gap-3 text-sm text-gray-500">
                <span class="font-medium">{{ $announcement->postedBy?->full_name ?? 'System' }}</span>
                <span>•</span>
                <span>{{ $announcement->created_at->format('M d, Y g:i A') }}</span>
            </div>
            <div class="mt-6 prose prose-sm max-w-none text-gray-700">
                <p class="whitespace-pre-wrap">{{ $announcement->content }}</p>
            </div>
        </div>
    </div>
</x-layouts.app>
