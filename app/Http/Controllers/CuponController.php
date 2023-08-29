<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CuponController extends Controller
{
    function coupon()
    {
        $coupons = Coupon::all();
        return view('admin.coupon.index', [
            'coupons' => $coupons,
        ]);
    }
    function coupon_store(Request $request)
    {
        Coupon::insert([
            'coupon_name' => $request->coupon_name,
            'type' => $request->type,
            'amount' => $request->amount,
            'expire_date' => $request->expire_date,
            'created_at' => Carbon::now(),
        ]);
        return back();
    }
}
