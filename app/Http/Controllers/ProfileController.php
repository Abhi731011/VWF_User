<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Custom password change function for user profile.
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->password = bcrypt($request->password);
        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Password changed successfully!');
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('master.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information, including image and banner upload.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->only([
            'name', 'email', 'phone', 'address', 'city', 'state', 'country', 'zip_code', 'admin_id', 'package_id'
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_img')) {
            $profileImg = $request->file('profile_img');
            $profileImgName = uniqid('profile_') . '.' . $profileImg->getClientOriginalExtension();
            $profileImg->move(public_path('uploads/profile'), $profileImgName);
            $data['profile_img'] = 'uploads/profile/' . $profileImgName;
        }

        // Handle banner image upload
        if ($request->hasFile('banner_img')) {
            $bannerImg = $request->file('banner_img');
            $bannerImgName = uniqid('banner_') . '.' . $bannerImg->getClientOriginalExtension();
            $bannerImg->move(public_path('uploads/banner'), $bannerImgName);
            $data['banner_img'] = 'uploads/banner/' . $bannerImgName;
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

    return Redirect::route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
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
