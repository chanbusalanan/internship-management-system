<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::with('postedBy')->latest()->paginate(10);

        return view('hr.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        return view('hr.announcements.create');
    }

    public function store(StoreAnnouncementRequest $request): RedirectResponse
    {
        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'posted_by' => auth()->id(),
        ]);

        return redirect()->route('hr.announcements.index')
            ->with('success', 'Announcement posted successfully.');
    }

    public function edit(Announcement $announcement): View
    {
        return view('hr.announcements.edit', compact('announcement'));
    }

    public function update(StoreAnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        $announcement->update($request->validated());

        return redirect()->route('hr.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        return redirect()->route('hr.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
