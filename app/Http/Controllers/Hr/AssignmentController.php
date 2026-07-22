<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssignmentRequest;
use App\Models\Application;
use App\Models\Assignment;
use App\Models\Department;
use App\Models\Supervisor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function index(): View
    {
        $assignments = Assignment::with('application.intern.user', 'department', 'supervisor.user')
            ->latest()
            ->paginate(10);

        return view('hr.assignments.index', compact('assignments'));
    }

    public function create(): View
    {
        $approvedApplications = Application::where('status', 'Approved')
            ->whereDoesntHave('assignment')
            ->with('intern.user')
            ->get();

        $departments = Department::all();
        $supervisors = Supervisor::with('user', 'department')->get();

        return view('hr.assignments.create', compact('approvedApplications', 'departments', 'supervisors'));
    }

    public function store(StoreAssignmentRequest $request): RedirectResponse
    {
        $application = Application::findOrFail($request->application_id);

        if ($application->assignment) {
            return redirect()->route('hr.assignments.index')
                ->with('error', 'This application already has an assignment.');
        }

        if ($application->status !== 'Approved') {
            return redirect()->route('hr.assignments.index')
                ->with('error', 'Only approved applications can be assigned.');
        }

        Assignment::create([
            'application_id' => $application->id,
            'department_id' => $request->department_id,
            'supervisor_id' => $request->supervisor_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'required_hours' => $request->required_hours,
            'completed_hours' => 0,
            'status' => 'Active',
        ]);

        return redirect()->route('hr.assignments.index')
            ->with('success', 'Intern assigned successfully.');
    }

    public function show(Assignment $assignment): View
    {
        $assignment->load('application.intern.user', 'department', 'supervisor.user', 'logs', 'evaluations');

        return view('hr.assignments.show', compact('assignment'));
    }

    public function complete(Assignment $assignment): RedirectResponse
    {
        $assignment->update(['status' => 'Completed']);

        return redirect()->route('hr.assignments.show', $assignment)
            ->with('success', 'Internship marked as completed.');
    }
}
