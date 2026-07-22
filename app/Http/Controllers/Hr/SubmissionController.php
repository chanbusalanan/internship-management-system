<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class SubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Submission::with('application.intern.user', 'requirement', 'reviewer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $submissions = $query->latest()->paginate(10);

        return view('hr.submissions.index', compact('submissions'));
    }

    public function show(Submission $submission): View
    {
        $submission->load('application.intern.user', 'requirement', 'reviewer');

        return view('hr.submissions.show', compact('submission'));
    }

    public function download(Submission $submission): StreamedResponse
    {
        return Storage::disk('local')->download($submission->file_path, $submission->original_filename);
    }

    public function approve(Request $request, Submission $submission): RedirectResponse
    {
        $submission->update([
            'status' => 'Approved',
            'remarks' => $request->input('remarks'),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('hr.submissions.show', $submission)
            ->with('success', 'Document approved successfully.');
    }

    public function reject(Request $request, Submission $submission): RedirectResponse
    {
        $submission->update([
            'status' => 'Rejected',
            'remarks' => $request->input('remarks', 'Document rejected.'),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('hr.submissions.show', $submission)
            ->with('success', 'Document rejected. The intern will need to resubmit.');
    }
}
