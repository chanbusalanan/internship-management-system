<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluationRequest;
use App\Models\Assignment;
use App\Models\Evaluation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EvaluationController extends Controller
{
    public function index(): View
    {
        $supervisor = auth()->user()->supervisor;
        $assignmentIds = $supervisor ? $supervisor->assignments()->pluck('id') : collect();

        $evaluations = Evaluation::with('assignment.application.intern.user')
            ->whereIn('assignment_id', $assignmentIds)
            ->latest()
            ->paginate(10);

        return view('supervisor.evaluations.index', compact('evaluations'));
    }

    public function create(Assignment $assignment): View
    {
        $supervisor = auth()->user()->supervisor;

        if ($assignment->supervisor_id !== $supervisor?->id) {
            abort(403);
        }

        $assignment->load('application.intern.user');

        return view('supervisor.evaluations.create', compact('assignment'));
    }

    public function store(StoreEvaluationRequest $request, Assignment $assignment): RedirectResponse
    {
        $supervisor = auth()->user()->supervisor;

        if ($assignment->supervisor_id !== $supervisor?->id) {
            abort(403);
        }

        Evaluation::create([
            'assignment_id' => $assignment->id,
            'score' => $request->score,
            'remarks' => $request->remarks,
            'evaluation_date' => $request->evaluation_date,
        ]);

        return redirect()->route('supervisor.evaluations.index')
            ->with('success', 'Evaluation submitted successfully.');
    }

    public function show(Evaluation $evaluation): View
    {
        $supervisor = auth()->user()->supervisor;

        if ($evaluation->assignment->supervisor_id !== $supervisor?->id) {
            abort(403);
        }

        $evaluation->load('assignment.application.intern.user');

        return view('supervisor.evaluations.show', compact('evaluation'));
    }
}
