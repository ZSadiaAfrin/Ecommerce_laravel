<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    function cart_store(Request $request)
    {
        if (Auth::guard('customerlogin')->id()) {
            if (Cart::where('customer_id',Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()) {
                Cart::where('customer_id',Auth::guard('customerlogin')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
                return back()->with('cart_added', 'card added successfully');
            } else {
                Cart::insert([
                    'customer_id' => Auth::guard('customerlogin')->id(),
                    'product_id' => $request->product_id,
                    'color_id' => $request->color_id,
                    'size_id' => $request->size_id,
                    'quantity' => $request->quantity,
                    'created_at' => Carbon::now(),
                ]);
                return back()->with('cart_added', 'card added successfully');
            }
        }
         else{
            return redirect()->route('customer.register.login')->withLogin('Please login for add to cart');
        }




        // print_r($request->all());

        // return back();

    }
    function remove_cart($cart_id)
    {
        Cart::find($cart_id)->delete();
        return back();
    }
    function cart_update(Request $request)
    {
        foreach ($request->quantity as $cart_id => $quantity) {
            Cart::find($cart_id)->update([
                'quantity' => $quantity,
            ]);
        }
        return back();
    }
}
