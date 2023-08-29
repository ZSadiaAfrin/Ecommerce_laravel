<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\subcategory;
use Illuminate\Http\Request;
use Str;

use Image;


class CategoryController extends Controller
{
    function category()
    {
        $categories = Category::all();
        $trash_categories = Category::onlyTrashed()->get();

        return view('admin.category.category', [
            'categories' => $categories,
            'trash_categories' => $trash_categories,
        ]);
    }
    function category_store(Request $request)
    {
        $request->validate([
            'category_name' => 'required | unique:categories',
            'category_image' => 'image',
        ]);

        if ($request->category_image == null) {
            Category::insert([
                'category_name' => $request->category_name,
            ]);
        } else {
            $random_number = random_int(100000, 999999);
            $category_image = $request->category_image;
            $extension = $category_image->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ', '-', $request->category_name)) . '-' . $random_number . '.' . $extension;
            Image::make($category_image)->save(public_path('uploads/category/' . $file_name));

            Category::insert([
                'category_name' => $request->category_name,
                'category_image' => $file_name,
            ]);
        }

        return back();
    }
    function category_delete($category_id)
    {
        Category::find($category_id)->delete();
        return back()->with('delete_success', 'Category Deleted Successfully!');
    }
    function category_edit($category_id)
    {
        $category_info = Category::find($category_id);
        return view('admin.category.edit_category', ['category_info' => $category_info,]);
    }
    function category_update(Request $request)
    {

        if ($request->category_image == null) {
            Category::find($request->category_id)->update([
                'category_name' => $request->category_name,
            ]);
            return back();

        }

        else {
            $cate_image = category::find($request->category_id);
            if($cate_image->category_image != null){
             $delete_form = public_path('uploads/category/' . $cate_image->category_image);
             unlink($delete_form);
            }





            $random_number = random_int(100000, 999999);
            $category_image = $request->category_image;
            $extension = $category_image->getClientOriginalExtension();
            $file_name = Str::lower(str_replace(' ', '-', $request->category_name)) . '-' . $random_number . '.' . $extension;

            Image::make($category_image)->save(public_path('uploads/category/' . $file_name));

            Category::find($request->category_id)->update([
                'category_name' => $request->category_name,
                'category_image' => $file_name,
            ]);
            return back();
        }

    }
    function category_restore($category_id)
    {
        Category::onlyTrashed()->find($category_id)->restore();
        return back();
    }
//category delete
    function category_del($category_id)
    {
        $present_image = Category::onlyTrashed()->find($category_id);
        $delete_from = public_path('uploads/category/' . $present_image->category_image);
        unlink($delete_from);

        $subcategories = subcategory::where('category_id', $category_id)->get();
        foreach($subcategories as $sub){
            $present_image = subcategory::find($sub->id);
            $delete_from = public_path('uploads/subcategory/' . $present_image->subcategory_image);
            unlink($delete_from);
        subcategory::find($sub->id)->delete();
        }


        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back()->with('permanent_delete_success', 'Category Deleted Successfully!');



    }
    function category_checked_delete(Request $request)
    {
        foreach ($request->category_id as $category) {
            Category::find($category)->delete();
        }
        return back();
    }
    function category_checked_restore(Request $request)
    {
        // print_r($request->category_id);
        foreach ($request->category_id as $category) {
            Category::onlyTrashed()->restore();
        }
        return back();
    }
    function category_checked_deleted_permanently(Request $request)
    {
        //  print_r($request->category_id);



            Category::onlyTrashed()->forceDelete();
            return back()->with('permanent_delete_success', 'Category Deleted Successfully!');



    }
}

