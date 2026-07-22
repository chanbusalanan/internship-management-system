<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Application;
use App\Models\Assignment;
use App\Models\DailyLog;
use App\Models\Submission;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'pending_applications' => Application::where('status', 'Pending')->count(),
            'approved_applications' => Application::where('status', 'Approved')->count(),
            'rejected_applications' => Application::where('status', 'Rejected')->count(),
            'pending_submissions' => Submission::where('status', 'Pending')->count(),
            'active_assignments' => Assignment::where('status', 'Active')->count(),
            'completed_assignments' => Assignment::where('status', 'Completed')->count(),
        ];

        $recentApplications = Application::with('intern.user')
            ->latest()
            ->limit(5)
            ->get();

        $announcements = Announcement::latest()->limit(5)->get();

        return view('hr.dashboard', compact('stats', 'recentApplications', 'announcements'));
    }
}
