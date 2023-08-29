<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Customerlogin;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    function google_callback()
    {
        $user = Socialite::driver('google')->user();

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
