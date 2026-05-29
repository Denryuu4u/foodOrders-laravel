<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // ─── SHOW ────────────────────────────────────────────────────
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    // ─── UPDATE INFO ─────────────────────────────────────────────
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:500',
            'gender'  => 'nullable|in:Male,Female,Other,Prefer not to say',
        ]);

        $user->update($request->only('name', 'email', 'address', 'gender'));

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    // ─── CHANGE PASSWORD ─────────────────────────────────────────
    public function changePassword(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('profile.show')
            ->with('success', 'Password changed successfully!');
    }

    // ─── UPLOAD PROFILE PICTURE ──────────────────────────────────
    public function uploadPicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = User::find(Auth::id());

        // Delete old picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
        }

        $file     = $request->file('profile_picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('profile_pictures', $filename, 'public');

        $user->update(['profile_picture' => $filename]);

        return redirect()->route('profile.show')
            ->with('success', 'Profile picture updated successfully!');
    }
}
