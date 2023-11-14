<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $contact = ContactUs::first();
        return Inertia::render('Contact/Index', [
            'contact' => $contact
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'facebook' => 'nullable|url|max:1000',
            'twitter' => 'nullable|url|max:1000',
            'instagram' => 'nullable|url|max:1000',
            'linkedin' => 'nullable|url|max:1000',
        ]);
        $contact = ContactUs::first();
        $contact->update($validated);

        return redirect()->back()->with('flash.banner', 'Links updated!')->with('flash.bannerStyle', 'success');
    }
}
