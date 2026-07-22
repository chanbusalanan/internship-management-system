<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\DailyLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DailyLogController extends Controller
{
    public function index(Request $request): View
    {
        $supervisor = auth()->user()->supervisor;
        $assignmentIds = $supervisor ? $supervisor->assignments()->pluck('id') : collect();

        $query = DailyLog::with('assignment.application.intern.user')
            ->whereIn('assignment_id', $assignmentIds);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $logs = $query->latest('log_date')->paginate(10);

        return view('supervisor.logs.index', compact('logs'));
    }

    public function show(DailyLog $log): View
    {
        $this->authorizeLog($log);

        $log->load('assignment.application.intern.user');

        return view('supervisor.logs.show', compact('log'));
    }

    public function approve(Request $request, DailyLog $log): RedirectResponse
    {
        $this->authorizeLog($log);

        $log->update([
            'status' => 'Approved',
            'reviewed_by' => auth()->user()->supervisor->id,
            'reviewed_at' => now(),
        ]);

        $log->assignment->increment('completed_hours', 8);

        return redirect()->route('supervisor.logs.index')
            ->with('success', 'Daily log approved successfully.');
    }

    public function reject(Request $request, DailyLog $log): RedirectResponse
    {
        $this->authorizeLog($log);

        $log->update([
            'status' => 'Rejected',
            'reviewed_by' => auth()->user()->supervisor->id,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('supervisor.logs.index')
            ->with('success', 'Daily log rejected.');
    }

    private function authorizeLog(DailyLog $log): void
    {
        $supervisor = auth()->user()->supervisor;

        if ($log->assignment->supervisor_id !== $supervisor?->id) {
            abort(403);
        }
    }
}
