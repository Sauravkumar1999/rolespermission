<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class UnAuthemticatedController extends Controller
{
    public function welcome()
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        envUpdate('APP_URL', "$protocol://$host");
        Artisan::call('optimize:clear');
        return view('welcome');
    }
    /**
     * @param NA
     * @return void
     */
    public function googleAuth()
    {
        return Socialite::driver('google')->redirect();
    }
    public function googleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::firstOrCreate(
            ['google_id' => $googleUser->id],
            [
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'profile' => $googleUser->avatar,
                'password' => Hash::make('password'),
                'email_verified_at' => $googleUser->user['email_verified'] ? now() : null,
            ]
        );
        $role = Role::where('name', 'user')->first();
        if ($user->wasRecentlyCreated) {
            $user->assignRole($role); // For Spatie
            // $user->attachRole($role); // For Laratrust
        }

        Auth::login($user);
        return redirect('/home');
    }
}
