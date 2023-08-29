<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    function index()
    {
        // return view('welcome');
        // return view('frontend.master');
        $categories = Category::all();
        $products = Product::all();
        $products = Product::take(8)->latest()->get();

        $best_selling=OrderProduct::groupBy('product_id')
        ->selectRaw('sum(quantity) as sum, product_id')
        ->orderBy('sum','DESC')->get();

        $best_selling_star=OrderProduct::groupBy('product_id')
        ->selectRaw('sum(star) as sum, product_id')
        ->orderBy('sum','DESC')->get();


        return view('frontend.index', ([
            'categories' => $categories,
            'products' => $products,
            'best_selling' =>$best_selling,
            'best_selling_star' =>$best_selling_star,
        ]));
    }
    function details($slug)

    {
        $slug_info=Product::where('slug',$slug)->get();
        $product_id=$slug_info->first()->id;

        $product_info = Product::find($product_id);
        $product_gallery = ProductGallery::where('product_id', $product_id)->get();
        $related_product = Product::where('category_id', $product_info->category_id)->where('id', '!=', $product_id)->get();

        $all_review=OrderProduct::where('product_id',$product_id)->whereNotNull('review')->get();
        $total_review=OrderProduct::where('product_id',$product_id)->whereNotNull('review')->count();
        $total_star=OrderProduct::where('product_id',$product_id)->whereNotNull('review')->sum('star');

        $available_colors = Inventory::where('product_id', $product_info->id)
            ->groupBy('color_id')
            ->selectRaw('count(*) as total, color_id')
            ->get();
        $available_size = Inventory::where('product_id', $product_info->id)
            ->groupBy('size_id')
            ->selectRaw('count(*) as total, size_id')
            ->get();
        return view('frontend.details', [
            'product_info' => $product_info,
            'product_gallery' => $product_gallery,
            'related_product' => $related_product,
            'available_colors' => $available_colors,
            'available_size' => $available_size,
            'all_review'=>$all_review,
            'total_review'=> $total_review,
            'total_star'=>$total_star,

        ]);
    }
    function getSize(Request $request)
    {
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        $str = '';

        foreach ($sizes as $size) {
            if ($size->rel_to_size->size_name == 'NA') {
                $str = '<div class="form-check size-option form-option form-check-inline mb-2">
                <input checked class="form-check-input" type="radio" name="size_id"
                    id="size' . $size->size_id . '" value="' . $size->size_id . '">
                <label class="form-option-label"
                    for="size' . $size->size_id . '">' . $size->rel_to_size->size_name . '</label>
                </div>';
            } else {
                $str .= '<div class="form-check size-option form-option form-check-inline mb-2">
            <input class="form-check-input" type="radio" name="size_id"
                id="size' . $size->size_id . '" value="' . $size->size_id . '">
            <label class="form-option-label"
                for="size' . $size->size_id . '">' . $size->rel_to_size->size_name . '</label>
            </div>';
            }
        }
        echo $str;
    }
    function cart(Request $request)
    {
        $msg = '';
        $type = '';
        $discount = 0;

        if(isset($request->coupon_name)){
            if (Coupon::where('coupon_name', $request->coupon_name)->exists()) {
                if (Carbon::now()->format('Y-m-d') <= Coupon::where('coupon_name', $request->coupon_name)->first()->expire_date) {
                    if (Coupon::where('coupon_name',$request->coupon_name)->first()->type==1) {
                        $discount=20;
                        $type=1;
                        // echo $discount;
                    }
                    else {
                        $discount=100;
                        $type=2;
                        // echo $discount;
                    }
                }
                else {
                    $discount=0;
                    $msg= 'Coupon  code expired';
                }
            }

            //coupon code does not exist
            else { $discount=0;
                 $msg= 'Coupon does not exist';
            }
        }

        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.cart', [
            'carts' => $carts,
            'discount' => $discount,
            'type' => $type,
            'msg' => $msg,
        ]);
    }
}
