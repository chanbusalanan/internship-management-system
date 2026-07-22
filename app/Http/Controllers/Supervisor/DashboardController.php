<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\DailyLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $supervisor = auth()->user()->supervisor;
        $assignmentIds = $supervisor ? $supervisor->assignments()->pluck('id') : collect();

        $stats = [
            'assigned_interns' => $supervisor ? $supervisor->assignments()->where('status', 'Active')->count() : 0,
            'pending_logs' => DailyLog::whereIn('assignment_id', $assignmentIds)->where('status', 'Pending')->count(),
            'approved_logs' => DailyLog::whereIn('assignment_id', $assignmentIds)->where('status', 'Approved')->count(),
            'total_evaluations' => \App\Models\Evaluation::whereIn('assignment_id', $assignmentIds)->count(),
        ];

        $pendingLogs = DailyLog::with('assignment.application.intern.user')
            ->whereIn('assignment_id', $assignmentIds)
            ->where('status', 'Pending')
            ->latest('log_date')
            ->limit(5)
            ->get();

        $announcements = Announcement::latest()->limit(5)->get();

        return view('supervisor.dashboard', compact('stats', 'pendingLogs', 'announcements'));
    }

    public function interns(Request $request): View
    {
        $supervisor = auth()->user()->supervisor;
        $assignments = $supervisor
            ? $supervisor->assignments()->with('application.intern.user', 'department')->latest()->paginate(10)
            : collect();

        return view('supervisor.interns.index', compact('assignments'));
    }

    public function internShow(\App\Models\Assignment $assignment): View
    {
        $supervisor = auth()->user()->supervisor;

        if ($assignment->supervisor_id !== $supervisor?->id) {
            abort(403);
        }

        $assignment->load('application.intern.user', 'department', 'logs', 'evaluations');

        return view('supervisor.interns.show', compact('assignment'));
    }
}
