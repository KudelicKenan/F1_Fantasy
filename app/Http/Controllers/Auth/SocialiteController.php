<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SocialiteController extends Controller
{
    // Redirect korisnika na Google OAuth
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Google OAuth nije konfigurisan. Provjerite GOOGLE_CLIENT_ID i GOOGLE_CLIENT_SECRET u .env fajlu.');
        }
    }

    // Callback ruta za Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(uniqid()),
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user, true);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            \Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Greška pri autentifikaciji sa Google-om: ' . $e->getMessage());
        }
    }

    // Isto za GitHub
    public function redirectToGithub()
    {
        try {
            return Socialite::driver('github')->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'GitHub OAuth nije konfigurisan. Provjerite GITHUB_CLIENT_ID i GITHUB_CLIENT_SECRET u .env fajlu.');
        }
    }

    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            $user = User::firstOrCreate(
                ['email' => $githubUser->getEmail()],
                [
                    'name' => $githubUser->getName() ?? $githubUser->getNickname(),
                    'password' => bcrypt(uniqid()),
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user, true);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            \Log::error('GitHub OAuth error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Greška pri autentifikaciji sa GitHub-om: ' . $e->getMessage());
        }
    }
}
