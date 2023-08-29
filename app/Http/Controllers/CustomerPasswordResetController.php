<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use App\Models\CustomerPassReset;
use App\Notifications\CustomerPassResetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CustomerPasswordResetController extends Controller
{
    function forgot_password()
    {
        return view('frontend.customer.password_reset');
    }
    function password_reset_req_send(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        if (Customerlogin::where('email', $request->email)->exists()) {
            $customer = Customerlogin::where('email', $request->email)->firstorFail();
            CustomerPassReset::where('customer_id', $customer->id)->delete();
            $info = CustomerPassReset::create([
                'customer_id' => $customer->id,
                'token' => uniqid(),
            ]);
            Notification::send($customer, new CustomerPassResetNotification($info));
        } else {

            return back()->with('invalid', 'email does not exists');
        }
    }
    function pass_reset_form($token)
    {
        return view('frontend.customer.password_reset_form', [
            'token' => $token,
        ]);
    }
    function password_reset_confirm(Request $request)
    {
        $rest_info = CustomerPassReset::where('token', $request->token)->firstorFail();

        Customerlogin::find($rest_info->customer_id)->update([
            'password' => bcrypt($request->password),
        ]);
        return back()->with('success', 'Password Reset Successfully');
    }
}
