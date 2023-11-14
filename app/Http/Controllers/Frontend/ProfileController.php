<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function index()
    {
        return Inertia::render('Profile');
    }

    public function editProfile(Request $request)
    {
        $request->validate(
            [
                'first_name' => 'nullable|max:100',
                'last_name' => 'nullable|max:100',
                'address' => 'nullable|max:100',
                'contact_number' => 'nullable|max:100',
            ]
        );
        $user = User::where('id',auth()->user()->id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->address = $request->address;
        $user->contact_number = $request->contact_number;
        $user->update();
        return redirect()->back()->with('flash.banner','Profile Edited!')->with('flash.bannerStyle', 'success');
    }
}
