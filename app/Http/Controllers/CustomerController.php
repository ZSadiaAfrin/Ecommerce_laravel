<?php

namespace App\Http\Controllers;

use App\Models\Customerlogin;
use App\Models\CustomerVerify;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Notifications\CustomerEmailVarifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;
use Illuminate\Support\Facades\Notification;
use Stripe\Customer;

class CustomerController extends Controller
{
    function customer_register_login()
    {
        return view('frontend.customer.register_login');
    }
    function customer_register_store(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:customerlogins',
        ]);

        // print_r($request->all());
        // die();

        $customer_id = Customerlogin::insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
        ]);

        $customer = Customerlogin::find($customer_id);


        $info = CustomerVerify::create([
            'customer_id' => $customer_id,
            'token' => uniqid(),
            'created_at' => Carbon::now(),
        ]);
        Notification::send($customer, new CustomerEmailVarifyNotification($info));
        return back()->with('verify', 'We have send you email verification mail to your mail please verify');


        // if (Auth::guard('customerlogin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        //     return redirect('/');
        // if (Auth::guard('customerlogin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        //     return redirect('/');
    }

    function customer_login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('customerlogin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // return redirect('/');
            if (Auth::guard('customerlogin')->user()->email_verified_at == Null) {
                Auth::guard('customerlogin')->logout();
                return back()->with('not_verified', 'Please Verified Your Email');
            } else {
                return redirect('/');
            }
        } else {
            return back()->with('wrong', 'Wrong Credential');
        }
    }
    function customer_logout()
    {
        Auth::guard('customerlogin')->logout();
        return redirect('/');
    }
    function customer_profile()
    {
        return view('frontend.customer.profile');
    }
    function customer_profile_update(Request $request)
    {
        if ($request->photo == null) {
            if ($request->password == null) {
                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'country' => $request->country,
                    'address' => $request->address,
                ]);
                return back();
            } else {
                if (Hash::check($request->old_password, Auth::guard('customerlogin')->user()->password)) {
                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'country' => $request->country,
                        'address' => $request->address,
                        'password' => Hash::make($request->password),
                    ]);
                    return back();
                } else {
                    return back()->with('old', 'Current Password wrong');
                }
            }
        }


        //photo exist password null
        else {


            if ($request->password == null) {
                $photo = $request->photo;
                $extension = $photo->getClientOriginalExtension();
                $file_name = Auth::guard('customerlogin')->id() . '.' . $extension;
                Image::make($photo)->save(public_path('uploads/customer/' . $file_name));


                Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'country' => $request->country,
                    'address' => $request->address,
                    'photo' => $file_name,
                ]);
                return back();
            } else {
                if (Hash::check($request->old_password, Auth::guard('customerlogin')->user()->password)) {

                    $photo = $request->photo;
                    $extension = $photo->getClientOriginalExtension();
                    $file_name = Auth::guard('customerlogin')->id() . '.' . $extension;
                    Image::make($photo)->save(public_path('uploads/customer/' . $file_name));


                    Customerlogin::find(Auth::guard('customerlogin')->id())->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'country' => $request->country,
                        'address' => $request->address,
                        'password' => Hash::make($request->password),
                        'photo' => $file_name,
                    ]);
                    return back();
                } else {
                    return back()->with('old', 'Current Password wrong');
                }
            }
        }
    }
    function myorder()
    {
        $myorders = Order::where('customer_id', Auth::guard('customerlogin')->id())->get();

        return view('frontend.customer.myorder', [
            'myorders' => $myorders,
        ]);
    }
    function review_store(Request $request)
    {
        OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->update([
            'review' => $request->review,
            'star' => $request->rating,
        ]);
        return back();
    }
    function customer_email_verify($token)
    {
        $customer = CustomerVerify::where('token', $token)->firstorFail();

        Customerlogin::find($customer->customer_id)->update([
            'email_verified_at' => Carbon::now(),
        ]);
        return redirect()->route('customer.register.login')->with('verify_success', 'Your Email Verify Successfully,Now You Can Login');
    }
    function send_emailverify_req()
    {
        return view('frontend.customer.emailvarified');
    }
    function email_verify_req_send(Request $request)
    {
        if (Customerlogin::where('email', $request->email)->exists()) {
            $customer = Customerlogin::where('email', $request->email)->firstorFail();

            // $info = CustomerVerify::where('customer_id', $customer->id)->firstorFail();
            CustomerVerify::where('customer_id', $customer->id)->delete();
            $info=CustomerVerify::create([
                'customer_id' => $customer->id,
                'token' => uniqid(),
                'created_at' => Carbon::now(),
            ]);
            Notification::send($customer, new CustomerEmailVarifyNotification($info));
            return back()->with('verify', 'We have sent a email verification mail to your email please verify!');
        } else {
            return back()->with('register', 'You did not register yet');
        }
    }
}
