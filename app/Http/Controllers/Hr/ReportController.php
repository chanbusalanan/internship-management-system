<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Evaluation;
use App\Models\Intern;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $totalInterns = Intern::count();
        $totalAssignments = Assignment::count();
        $activeAssignments = Assignment::where('status', 'Active')->count();
        $completedAssignments = Assignment::where('status', 'Completed')->count();
        $totalEvaluations = Evaluation::count();

        $assignments = Assignment::with('application.intern.user', 'department', 'supervisor.user')
            ->latest()
            ->paginate(15);

        return view('hr.reports.index', compact(
            'totalInterns',
            'totalAssignments',
            'activeAssignments',
            'completedAssignments',
            'totalEvaluations',
            'assignments',
        ));
    }
}
