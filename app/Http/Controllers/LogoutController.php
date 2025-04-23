<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function perform(Request $request)
    {
        Session::flush();
    
        if (Auth::guard('trainer')->check()) {
            Auth::guard('trainer')->logout();
        } else {
            Auth::logout();
        }
    
        return redirect()->route('login.show');
    }
    
    
}