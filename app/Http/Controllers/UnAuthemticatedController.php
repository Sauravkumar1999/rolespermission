<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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
}
