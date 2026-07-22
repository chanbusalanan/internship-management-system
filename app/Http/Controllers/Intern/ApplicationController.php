<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Models\Evaluation;
use App\Models\Requirement;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(): View
    {
        $intern = auth()->user()->intern;
        $applications = $intern->applications()->with('submissions.requirement', 'assignment')->latest()->get();

        return view('intern.applications.index', compact('applications'));
    }

    public function create(): View
    {
        return view('intern.applications.create');
    }

    public function store(StoreApplicationRequest $request): RedirectResponse
    {
        $intern = auth()->user()->intern;

        $existing = $intern->applications()->where('status', 'Pending')->first();

        if ($existing) {
            return redirect()->route('intern.applications.index')
                ->with('error', 'You already have a pending application.');
        }

        Application::create([
            'intern_id' => $intern->id,
            'application_date' => $request->application_date,
            'status' => 'Pending',
        ]);

        return redirect()->route('intern.applications.index')
            ->with('success', 'Internship application submitted successfully.');
    }

    public function show(Application $application): View
    {
        $this->authorize('view', $application);

        $application->load('submissions.requirement', 'assignment.department', 'assignment.supervisor.user');

        return view('intern.applications.show', compact('application'));
    }

    public function createSubmission(Application $application): View
    {
        $this->authorize('view', $application);

        $requirements = Requirement::where('is_required', true)->get();
        $submittedIds = $application->submissions()->pluck('requirement_id')->toArray();
        $availableRequirements = $requirements->reject(fn ($r) => in_array($r->id, $submittedIds));

        return view('intern.applications.submit', compact('application', 'availableRequirements'));
    }

    public function storeSubmission(Request $request, Application $application): RedirectResponse
    {
        $this->authorize('view', $application);

        $validated = $request->validate([
            'requirement_id' => ['required', 'exists:requirements,id'],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:5120'],
        ]);

        $file = $request->file('file');
        $path = $file->store('requirements', 'local');
        $originalName = $file->getClientOriginalName();

        Submission::create([
            'application_id' => $application->id,
            'requirement_id' => $validated['requirement_id'],
            'file_path' => $path,
            'original_filename' => $originalName,
            'status' => 'Pending',
        ]);

        return redirect()->route('intern.applications.show', $application)
            ->with('success', 'Document uploaded successfully.');
    }

    public function evaluations(): View
    {
        $intern = auth()->user()->intern;
        $application = $intern->applications()->latest()->first();
        $evaluations = $application?->assignment
            ? $application->assignment->evaluations()->latest()->get()
            : collect();

        return view('intern.evaluations.index', compact('evaluations'));
    }
}
