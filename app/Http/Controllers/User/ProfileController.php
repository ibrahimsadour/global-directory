<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function settings()
    {
        return view('user.user-setting');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'oldpassword' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('user.settings')->with('status', 'password-updated');
    }

    public function edit()
    {
        return view('user.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->bio = $request->bio;

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }
}
