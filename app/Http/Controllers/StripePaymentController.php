<?php
namespace App\Http\Controllers;
use Session;
use Stripe;
use App\Mail\CustomerInvoiceMail;
use App\Models\BillingDetails;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ShippingDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOption\Option;
use Str;
use Illuminate\Support\Facades\Mail;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $data=session('info');
        $total=$data['sub_total']+$data['charge']-$data['discount'];


        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
                "amount" => $total * 100,
                "currency" => "bdt",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com."
        ]);
        $random_number = random_int(1000000, 9999999);
        $city = City::find($data['city_id']);
        $order_id = '#' . Str::upper(substr($city->name, 0, 3)) . '-' . $random_number;

            Order::insert([
                // 'order_id' => '#'.Str::upper(substr($city->name, 0, 3)) . '-' . $random_number,
                'order_id' => $order_id,
                'customer_id' => Auth::guard('customerlogin')->id(),
                'subtotal' => $data['sub_total'],
                'total' => $total,
                'charge' => $data['charge'],
                'discount' => $data['discount'],
                'payment_method' => $data['payment_method'],
                'created_at' => Carbon::now(),

            ]);
            BillingDetails::insert([
                'order_id' => $order_id,
                'customer_id' => Auth::guard('customerlogin')->id(),
                'name' => Auth::guard('customerlogin')->user()->name,
                'email' => Auth::guard('customerlogin')->user()->email,
                'mobile' => $data['billing_mobile'],
                'company' => $data['company'],
                'address' => Auth::guard('customerlogin')->user()->address,
                'created_at' => Carbon::now(),

            ]);
            ShippingDetails::insert([
                'order_id' => $order_id,
                'name' => $data['name'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'country_id' => $data['country_id'],
                'city_id' => $data['city_id'],
                'address' => $data['address'],
                'zip' => $data['zip'],
                'notes' => $data['notes'],
                'created_at' => Carbon::now(),

            ]);
            $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
            foreach ($carts as $cart) {
                OrderProduct::insert([
                    'order_id' => $order_id,
                    'customer_id' => Auth::guard('customerlogin')->id(),
                    'product_id' => $cart->product_id,
                    'price' => $cart->rel_to_product->after_discount,
                    'color_id' => $cart->color_id,
                    'size_id' => $cart->size_id,
                    'quantity' => $cart->quantity,
                    'created_at' => Carbon::now(),

                ]);

                Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
                // $cart=Cart::find($cart->id)->delete();

            }
            $mail = Auth::guard('customerlogin')->user()->email;

            Mail::to($mail)->send(new CustomerInvoiceMail($order_id));
            $order_id_new = substr($order_id, 1);
            return redirect()->route('order.success', $order_id_new)->withOrdersuccess('Cart Added!');





    }
}
