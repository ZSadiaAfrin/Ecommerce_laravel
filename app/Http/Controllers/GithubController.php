<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GithubController extends Controller
{
    function github_redirect()
    {
        return Socialite::driver('github')->redirect();
    }
    function github_callback()
    {
        $user = Socialite::driver('github')->user();

        if(Customerlogin::where('email', $user->getEmail())->exists()){
            if (Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => '@abc569@'])) {
                return redirect('/');
            }
        }
        else{
            Customerlogin::insert([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => bcrypt('@abc569@'),
                'created_at' => Carbon::now(),
            ]);
            if (Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => '@abc569@'])) {
                return redirect('/');
            }

        }




        // Customerlogin::insert([
        //     'name' => $user->getName(),
        //     'email' => $user->getEmail(),
        //     'password' => bcrypt('@abc569@'),
        //     'created_at' => Carbon::now(),
        // ]);
        // if (Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => '@abc569@'])) {
        //     return redirect('/');
        // }
        // else {
        //     abort('404');
        // }
    }
}
