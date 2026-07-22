<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        $announcements = Announcement::with('postedBy')->latest()->paginate(10);

        return view('intern.announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement): View
    {
        return view('intern.announcements.show', compact('announcement'));
    }
}
