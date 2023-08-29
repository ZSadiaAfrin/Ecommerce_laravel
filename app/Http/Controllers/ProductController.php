<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;


use Str;
use Image;

class ProductController extends Controller
{
    function add_product()
    {
        $categories = Category::all();
        $subcategories = subcategory::all();
        $brands = Brand::all();
        return view('admin.product.add_product', [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'brands' => $brands,
        ]);
    }
    function getSubcategory(Request $request)
    {
        $subcategories = subcategory::where('category_id', $request->category_id)->get();
        $str = '<option value="">--Select Any--</option>';
        foreach ($subcategories as $subcategory) {
            $str .= '<option value="' . $subcategory->id .'">' . $subcategory->subcategory_name .'</option>';
        }
        echo $str;
    }
    function product_store(Request $request)
    {

        $random_number = random_int(10000, 99999);
        $slug = Str::lower(str_replace(' ', '-', $request->product_name)) . '-' . $random_number;
        $sku = Str::Upper(str_replace(' ', '-', substr($request->product_name, 0, 2))) .'-' . $random_number;
        $product_id = Product::insertGetId([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'discount' => $request->discount,
            'after_discount' => $request->price - ($request->price * $request->discount) / 100,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand' => $request->brand,
            'short_desp' => $request->short_desp,
            'long_desp' => $request->long_desp,
            'additional_info' => $request->additional_info,
            'sku' => $sku,
            'slug' => $slug,
            'created_at' => Carbon::now(),


        ]);
        $preview_image = $request->preview;
        if ($preview_image != null) {
            $extension = $preview_image->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ', '-', $request->product_name)) .'-' . $random_number . '.' . $extension;
            Image::make($preview_image)->save(public_path('uploads/product/preview/' . $file_name));
            Product::find($product_id)->update([
                'preview' => $file_name,
            ]);
        }



        $gallery_image = $request->gallery;
        if ($gallery_image != null) {
            foreach ($gallery_image as $sl => $gallery); {
                $extension_gallery = $gallery->getClientOriginalExtension();
                $file_name_gallery = Str::lower(str_replace(' ', '-', $request->product_name)) . '-' . $random_number . $sl .'.' . $extension_gallery;
                Image::make($gallery)->save(public_path('uploads/product/gallery/' . $file_name_gallery));
                ProductGallery::insert([
                    'product_id' => $product_id,
                    'gallery' => $file_name_gallery,
                    'created_at' => Carbon::now(),

                ]);
            }
        }
        return back();
    }
    function product_list()
    {
        $all_products = Product::all();

        return view('admin.product.product_list', [
            'all_products' => $all_products,

        ]);
    }

    function product_edit($product_id)
    {
        $product_info = Product::find($product_id);
        $gallery_images = ProductGallery::where('product_id', $product_info->id)->get();
        $categories = Category::all();
        $subcategories = subcategory::all();
        $brands = Brand::all();
        return view('admin.product.product_edit', [
            'product_info' => $product_info,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'brands' => $brands,
            'gallery_images' => $gallery_images,
        ]);
    }
    function product_update(Request $request)
    {

        $random_number = random_int(10000, 99999);
        $gallery_image = $request->gallery;
        //if preview empty
        if ($request->preview == null) {
            //if gallery empty
            if ($request->gallery == null) {
                Product::find($request->product_id)->update([
                    'product_name' => $request->product_name,
                    'price' => $request->price,
                    'discount' => $request->discount,
                    'after_discount' => $request->price - ($request->price * $request->discount) / 100,
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'brand' => $request->brand,
                    'short_desp' => $request->short_desp,
                    'long_desp' => $request->long_desp,
                    'additional_info' => $request->additional_info,
                    'created_at' => Carbon::now(),
                ]);
            }
            //if gallery not empty
            else {

                $present_gallery = ProductGallery::where('product_id', $request->product_id)->get();
                foreach ($present_gallery as $gal) {
                    $delete_form = public_path('uploads/product/gallery/' . $gal->gallery);
                    unlink($delete_form);
                    ProductGallery::where('product_id', $gal->product_id)->delete();
                }


                // $present_gallery = ProductGallery::where('product_id', $request->product_id)->get();
                // foreach ($present_gallery as $gal) {
                //     if ($gal->gallery != null) {
                //         $delete_form = public_path('uploads/product/gallery/' . $gal->gallery);
                //         unlink($delete_form);
                //         ProductGallery::where('product_id', $gal->product_id)->delete();
                //     }

                // }

                // $delete_form = public_path('uploads/product/gallery/' . $gal->gallery);
                // unlink($delete_form);
                // Product::where('product_id', $gal->id)->delete();



                foreach ($gallery_image as $sl => $gallery) {
                    $extension_gallery = $gallery->getClientOriginalExtension();
                    $file_name_gallery = Str::lower(str_replace(' ', '-', $request->product_name)) . '-' . $random_number . $sl . '.' . $extension_gallery;
                    Image::make($gallery)->save(public_path('uploads/product/gallery/' . $file_name_gallery));
                    ProductGallery::insert([
                        'product_id' => $request->product_id,
                        'gallery' => $file_name_gallery,
                        'created_at' => Carbon::now(),

                    ]);
                }
            }
        }
        //if preview not empty
        else {
            //if gallery empty
            if ($request->gallery == null) {

                $prev_image = Product::find($request->product_id);
                $delete_prev = public_path('uploads/product/preview/' . $prev_image->preview);
                unlink($delete_prev);

                // $prev_image = Product::find($request->product_id);
                // if($prev_image->preview !=null){
                //     $delete_prev = public_path('uploads/product/preview/' . $prev_image->preview);
                //     unlink($delete_prev);
                // }


                $preview_image = $request->preview;
                $extension = $preview_image->getClientOriginalExtension();
                $file_name = Str::lower(str_replace(' ', '-', $request->product_name)) . '-' . $random_number . '.' . $extension;
                Image::make($preview_image)->save(public_path('uploads/product/preview/' . $file_name));
                // Product::find($request->product_id)->update([
                //     'preview' => $file_name,
                // ]);
                Product::find($request->product_id)->update([
                    'product_name' => $request->product_name,
                    'price' => $request->price,
                    'discount' => $request->discount,
                    'after_discount' => $request->price - ($request->price * $request->discount) / 100,
                    'category_id' => $request->category_id,
                    'subcategory_id' => $request->subcategory_id,
                    'brand' => $request->brand,
                    'short_desp' => $request->short_desp,
                    'long_desp' => $request->long_desp,
                    'additional_info' => $request->additional_info,
                    'preview' => $file_name,
                    'created_at' => Carbon::now(),
                ]);

            }



            //if galler not empty
            else {
                $prev_image = Product::find($request->product_id);
                $delete_prev = public_path('uploads/product/preview/' . $prev_image->preview);
                unlink($delete_prev);

                // $prev_image = Product::find($request->product_id);
                // if ($prev_image->preview != null) {
                //     $delete_prev = public_path('uploads/product/preview/' . $prev_image->preview);
                //     unlink($delete_prev);
                // }

                $preview_image = $request->preview;
                $extension = $preview_image->getClientOriginalExtension();
                $file_name = Str::lower(str_replace(' ', '-', $request->product_name)) . '-' . $random_number .'.' . $extension;
                Image::make($preview_image)->save(public_path('uploads/product/preview/' . $file_name));




                $present_gallery = ProductGallery::where('product_id', $request->product_id)->get();
                foreach ($present_gallery as $gal); {
                    $delete_form = public_path('uploads/product/gallery/' . $gal->gallery);
                    unlink($delete_form);
                    ProductGallery::where('product_id', $gal->product_id)->delete();
                }


                // $present_gallery = ProductGallery::where('product_id', $request->product_id)->get();
                // foreach ($present_gallery as $gal) {
                //     if ($gal->gallery != null) {
                //         $delete_form = public_path('uploads/product/gallery/' . $gal->gallery);
                //         unlink($delete_form);
                //         ProductGallery::where('product_id', $gal->product_id)->delete();
                //     }

                // }
                    foreach ($gallery_image as $sl => $gallery) {
                        $extension_gallery = $gallery->getClientOriginalExtension();
                        $file_name_gallery = Str::lower(str_replace(' ', '-', $request->product_name)) .'-' . $random_number . $sl . '.' . $extension_gallery;
                        Image::make($gallery)->save(public_path('uploads/product/gallery/' . $file_name_gallery));
                        ProductGallery::insert([
                            'product_id' => $request->product_id,
                            'gallery' => $file_name_gallery,
                            'created_at' => Carbon::now(),

                        ]);
                    }
                    Product::find($request->product_id)->update([
                        'product_name' => $request->product_name,
                        'price' => $request->price,
                        'discount' => $request->discount,
                        'after_discount' => $request->price - ($request->price * $request->discount) / 100,
                        'category_id' => $request->category_id,
                        'subcategory_id' => $request->subcategory_id,
                        'brand' => $request->brand,
                        'short_desp' => $request->short_desp,
                        'long_desp' => $request->long_desp,
                        'additional_info' => $request->additional_info,
                        'preview' => $file_name,
                        'created_at' => Carbon::now(),
                    ]);
                }

            }
        return back();
           }

//product delete
            function product_delete($product_id){

                Product::find($product_id)->delete();
                // Alert::success('delete', 'deleted successfully');
                return back();
            }
        }



