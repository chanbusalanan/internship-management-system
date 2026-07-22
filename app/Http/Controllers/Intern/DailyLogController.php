<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDailyLogRequest;
use App\Models\Assignment;
use App\Models\DailyLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DailyLogController extends Controller
{
    public function index(): View
    {
        $intern = auth()->user()->intern;
        $application = $intern->applications()->where('status', 'Approved')->latest()->first();
        $assignment = $application?->assignment;

        if (! $assignment) {
            return view('intern.logs.no-assignment');
        }

        $logs = $assignment->logs()->latest('log_date')->get();

        return view('intern.logs.index', compact('logs', 'assignment'));
    }

    public function create(): View
    {
        $intern = auth()->user()->intern;
        $application = $intern->applications()->where('status', 'Approved')->latest()->first();
        $assignment = $application?->assignment;

        if (! $assignment) {
            return view('intern.logs.no-assignment');
        }

        return view('intern.logs.create', compact('assignment'));
    }

    public function store(StoreDailyLogRequest $request): RedirectResponse
    {
        $intern = auth()->user()->intern;
        $application = $intern->applications()->where('status', 'Approved')->latest()->first();
        $assignment = $application?->assignment;

        if (! $assignment) {
            return redirect()->route('intern.logs.index')
                ->with('error', 'You do not have an active internship assignment.');
        }

        $existingLog = $assignment->logs()->whereDate('log_date', $request->log_date)->first();

        if ($existingLog) {
            return redirect()->route('intern.logs.create')
                ->with('error', 'A log for this date has already been submitted.')
                ->withInput();
        }

        DailyLog::create([
            'assignment_id' => $assignment->id,
            'log_date' => $request->log_date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'activity_description' => $request->activity_description,
            'status' => 'Pending',
        ]);

        return redirect()->route('intern.logs.index')
            ->with('success', 'Daily log submitted successfully.');
    }

    public function show(DailyLog $log): View
    {
        $intern = auth()->user()->intern;
        $assignment = $log->assignment;

        if ($assignment->application->intern_id !== $intern->id) {
            abort(403);
        }

        return view('intern.logs.show', compact('log'));
    }
}
