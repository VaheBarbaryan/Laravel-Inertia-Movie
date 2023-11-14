<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ChangeEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

class EmailController extends Controller
{
    public function index()
    {
        return Inertia::render('ChangeEmail');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_email' => 'required|email|unique:users,email',
            'confirm_new_email' => 'required|email|same:new_email',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return redirect()->back()->withErrors(['password' => 'Password is wrong']);
        }

//        dd($request->all());
        $token = Str::random(40);
        $subject = 'Inertia movie Change Email';
        $body = [
            'message' => 'Change Email Link',
            'url' => env("APP_URL") . "verifyEmail/" . auth()->user()->id . "/" . $token
        ];
        Mail::to($request->new_email)->send(new \App\Mail\ChangeEmail($subject, $body));
        $changeEmail = ChangeEmail::where(['email' => $request->new_email])->first();
        if (!$changeEmail) {
            $changeEmail = new ChangeEmail();
        }
        $changeEmail->email = $request->new_email;
        $changeEmail->token = $token;
        $changeEmail->created_at = Carbon::now();
        $changeEmail->save();

        return redirect()->back()->with('flash.banner', 'Verification mail send successfully')
            ->with('flash.bannerStyle', 'success');
    }

    public function change($id, $token)
    {
        $user = User::where('id', $id)->first();
        $changeEmail = ChangeEmail::where('token', $token)->where('created_at', '>=', Carbon::now()->subMinutes(1))->first();
        if (!$user || !$changeEmail) {
            abort(403);
        }
        $user->email = $changeEmail->email;
        $user->markEmailAsVerified();
        $user->save();
        $changeEmail->delete();
        return redirect()->route('index');
    }
}
