<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInternProfileRequest;
use App\Models\Intern;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $intern = auth()->user()->intern;

        if (! $intern) {
            return view('intern.no-profile');
        }

        return view('intern.profile.edit', compact('intern'));
    }

    public function update(UpdateInternProfileRequest $request): RedirectResponse
    {
        $intern = auth()->user()->intern;

        if (! $intern) {
            return redirect()->route('intern.dashboard')
                ->with('error', 'No intern profile found.');
        }

        $intern->user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        $intern->update([
            'student_number' => $request->student_number,
            'school' => $request->school,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'phone' => $request->phone,
            'address' => $request->address,
            'emergency_contact' => $request->emergency_contact,
        ]);

        return redirect()->route('intern.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}
