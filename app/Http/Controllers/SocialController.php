<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirectToGoggle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoggleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect()->route('dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'email_verified_at' => now(),
                    'password' => encrypt('password'),
                ]);
                $newUser->assignRole('User');
                Auth::login($newUser);
                return redirect()->route('dashboard');
            }

        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
            $finduser = User::where('email', $user->email)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect()->route('dashboard');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'email_verified_at' => now(),
                    'password' => encrypt('password'),
                ]);
                $newUser->assignRole('User');
                Auth::login($newUser);
                return redirect()->route('dashboard');
            }

        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
