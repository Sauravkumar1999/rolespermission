<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',['pageTitle'=> trans('dashboard.dashboard')]);
    }
    public function getSessionExpiration()
    {
        $lifetime = config('session.lifetime');
        $currentTime = Carbon::now();
        $expirationTime = $currentTime->addMinutes($lifetime);
        return $expirationTime;
    }
}
