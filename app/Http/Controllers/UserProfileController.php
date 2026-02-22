<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Http\Models\Profile;
use Http\Models\User;

class UserProfileController extends Controller
{


    public function show()
    {

        $user = auth()->user()->load('profile');
        return view('profile.show', compact('user'));
    
    }
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $profile = $user->profile;

        // Handle image upload
        if ($request->hasFile('profile_picture')) {

            if ($profile->profile_picture && Storage::disk('public')->exists($profile->profile_picture)) {
                Storage::disk('public')->delete($profile->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $profile->profile_picture = $path;
        }

        $profile->phone_number = $request->phone_number;
        $profile->address = $request->address;
        $profile->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}