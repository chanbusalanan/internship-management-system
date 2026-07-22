<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequirementRequest;
use App\Models\Requirement;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RequirementController extends Controller
{
    public function index(): View
    {
        $requirements = Requirement::withCount('submissions')->paginate(10);

        return view('admin.requirements.index', compact('requirements'));
    }

    public function store(StoreRequirementRequest $request): RedirectResponse
    {
        Requirement::create($request->validated());

        return redirect()->route('admin.requirements.index')
            ->with('success', 'Requirement created successfully.');
    }

    public function edit(Requirement $requirement): View
    {
        return view('admin.requirements.edit', compact('requirement'));
    }

    public function update(StoreRequirementRequest $request, Requirement $requirement): RedirectResponse
    {
        $requirement->update($request->validated());

        return redirect()->route('admin.requirements.index')
            ->with('success', 'Requirement updated successfully.');
    }

    public function destroy(Requirement $requirement): RedirectResponse
    {
        if ($requirement->submissions()->exists()) {
            return redirect()->route('admin.requirements.index')
                ->with('error', 'Cannot delete a requirement with existing submissions.');
        }

        $requirement->delete();

        return redirect()->route('admin.requirements.index')
            ->with('success', 'Requirement deleted successfully.');
    }
}
