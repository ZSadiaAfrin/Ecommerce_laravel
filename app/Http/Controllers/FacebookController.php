<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customerlogin;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    function facebook_redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }
    function facebook_callback(){
        $user = Socialite::driver('facebook')->user();

        if(Customerlogin::where('email',$user->getEmail())->exists()){
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



    }
}
