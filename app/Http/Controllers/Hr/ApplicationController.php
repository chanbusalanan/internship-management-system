<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Application::with('intern.user', 'submissions');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(10);

        return view('hr.applications.index', compact('applications'));
    }

    public function show(Application $application): View
    {
        $application->load('intern.user', 'submissions.requirement.reviewer', 'assignment.department', 'assignment.supervisor.user');

        return view('hr.applications.show', compact('application'));
    }

    public function approve(Request $request, Application $application): RedirectResponse
    {
        $application->update([
            'status' => 'Approved',
            'remarks' => $request->input('remarks', 'Application approved.'),
        ]);

        return redirect()->route('hr.applications.show', $application)
            ->with('success', 'Application approved successfully.');
    }

    public function reject(Request $request, Application $application): RedirectResponse
    {
        $application->update([
            'status' => 'Rejected',
            'remarks' => $request->input('remarks', 'Application rejected.'),
        ]);

        return redirect()->route('hr.applications.show', $application)
            ->with('success', 'Application rejected.');
    }
}
