<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Patient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the patient\'s profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $patient = $user->patient; // Assuming a one-to-one relationship between User and Patient

        return view('patient.profile.edit', [
            'user' => $user,
            'patient' => $patient,
            'showModalEdit' => false, // Ensure modal is closed by default
        ]);
    }

    /**
     * Display the patient's profile.
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        $patient = $user->patient;

        return view('patient.profile.show', [
            'user' => $user,
            'patient' => $patient,
        ]);
    }

    /**
     * Update the patient\'s profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        Log::info('Patient Profile Update: Incoming Request Data', $request->all());
        $user = $request->user();
        $patient = $user->patient;

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'philhealth_number' => ['nullable', 'string', 'max:255', 'unique:patients,philhealth_number,' . $patient->id],
            'gender' => ['required', 'string', 'in:Male,Female'],
            'marital_status' => ['nullable', 'string', 'in:Married,Single,Divorced,Separated,Widowed,Other'],
            'language' => ['nullable', 'string', 'max:255'],
            'race' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'barangay' => ['nullable', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'phone_number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'employment_status' => ['nullable', 'string', 'in:Active duty military,Employed,Student,Child,Disabled,Retired,Self employed,Other'],

            // Emergency/Next of Kin Contact Information
            'emergency_last_name' => ['nullable', 'string', 'max:255'],
            'emergency_first_name' => ['nullable', 'string', 'max:255'],
            'emergency_relationship' => ['nullable', 'string', 'max:255'],
            // 'emergency_address' => ['nullable', 'string'], // This field is removed in a migration
            // 'emergency_apt_num' => ['nullable', 'string', 'max:255'], // This field is removed in a migration
            'emergency_city' => ['nullable', 'string', 'max:255'],
            // 'emergency_state' => ['nullable', 'string', 'max:255'], // This field is removed in a migration
            'emergency_zip_code' => ['nullable', 'string', 'max:20'],
            'emergency_home_phone' => ['nullable', 'string', 'max:255'],
            'emergency_work_phone' => ['nullable', 'string', 'max:255'],
            'emergency_other_phone' => ['nullable', 'string', 'max:255'],
            'emergency_other_phone_cell' => ['nullable', 'boolean'],
            'emergency_other_phone_pager' => ['nullable', 'boolean'],
            'emergency_other_phone_fax' => ['nullable', 'boolean'],
            'emergency_region' => ['nullable', 'string', 'max:255'],
            'emergency_province' => ['nullable', 'string', 'max:255'],
            'emergency_barangay' => ['nullable', 'string', 'max:255'],

            // Other Contact Information (Not Living with Patient)
            'other_last_name' => ['nullable', 'string', 'max:255'],
            'other_first_name' => ['nullable', 'string', 'max:255'],
            'other_relationship' => ['nullable', 'string', 'max:255'],
            // 'other_address' => ['nullable', 'string'], // This field is removed in a migration
            // 'other_apt_num' => ['nullable', 'string', 'max:255'], // This field is removed in a migration
            'other_city' => ['nullable', 'string', 'max:255'],
            // 'other_state' => ['nullable', 'string', 'max:255'], // This field is removed in a migration
            'other_zip_code' => ['nullable', 'string', 'max:20'],
            'other_home_phone' => ['nullable', 'string', 'max:255'],
            'other_work_phone' => ['nullable', 'string', 'max:255'],
            'other_other_phone' => ['nullable', 'string', 'max:255'],
            'other_other_phone_cell' => ['nullable', 'boolean'],
            'other_other_phone_pager' => ['nullable', 'boolean'],
            'other_other_phone_fax' => ['nullable', 'boolean'],
            'other_region' => ['nullable', 'string', 'max:255'],
            'other_province' => ['nullable', 'string', 'max:255'],
            'other_barangay' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);
        Log::info('Patient Profile Update: Validation Passed');
        Log::info('Patient Profile Update: Validated Data', $validated);

        if ($request->hasFile('photo')) {
            if ($patient->photo) {
                Storage::disk('public')->delete($patient->photo);
            }
            $path = $request->file('photo')->store('photos/patients', 'public');
            $validated['photo'] = $path;
        }
        Log::info('Patient Profile Update: Patient data BEFORE update', $patient->toArray());
        $patient->update($validated);
        Log::info('Patient Profile Update: Patient model updated', $patient->toArray());

        // Update user email if it has changed
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
            $request->user()->save();
            Log::info('Patient Profile Update: User email updated', ['email' => $request->user()->email]);
        }

        return Redirect::route('patient.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the patient\'s account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
