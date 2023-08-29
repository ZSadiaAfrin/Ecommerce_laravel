<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\subcategory;
use Illuminate\Http\Request;

use Image;

use Str;

class SubCategoryController extends Controller
{
    function subcategory(){
        $categories = Category::all();
        $subcategories = subcategory::all();

        return view('admin.category.subcategory',[
        'categories'=>$categories,
        'subcategories'=>$subcategories,
        ]);
    }
function subcategory_store(Request $request){
    if($request->subcategory_image == null){
        subcategory::insert([
            'subcategory_name' => $request->subcategory_name,
            'category_id' => $request->category_id,
        ]);
        return back();
    }

else{
    $random_number = random_int(100000, 999999);
    $subcategory_image = $request->subcategory_image;
    $extension = $subcategory_image->getClientOriginalExtension();
    $file_name = Str::lower(str_replace(' ', '-', $request->subcategory_name)) . '-' . $random_number . '.' . $extension;



    Image::make($subcategory_image)->save(public_path('uploads/subcategory/' . $file_name));
    subcategory::insert([
        'subcategory_name' => $request->subcategory_name,
        'category_id' => $request->category_id,
        'subcategory_image' => $file_name ,
    ]);
    return back();
}
}
//subcategory edit
function subcategory_edit($subcategory_id){
        $subcategory_info = subcategory::find($subcategory_id);
        $categories = Category::all();
        return view('admin.category.edit_subcategory',[
            'subcategory_info'=>$subcategory_info,
            'categories'=>$categories,
        ]);
}
function subcategory_update(Request $request){
    if($request->subcategory_image ==null){
            subcategory::find($request->subcategory_id)->update([
                'subcategory_name'=>$request->subcategory_name,
                'category_id'=>$request->category_id,
            ]);
            return back();

    }else{
            $subcate_image = subcategory::find($request->subcategory_id);
            if($subcate_image->subcategory_image != null){
             $delete_form = public_path('uploads/subcategory/' . $subcate_image->subcategory_image);
             unlink($delete_form);
            }







        $random_number = random_int(100000, 999999);
        $subcategory_image = $request->subcategory_image;
        $extension = $subcategory_image->getClientOriginalExtension();
        $file_name = Str::lower(str_replace(' ', '-', $request->subcategory_name)) . '-' . $random_number . '.' . $extension;



        Image::make($subcategory_image)->save(public_path('uploads/subcategory/' . $file_name));
        subcategory::find($request->subcategory_id)->update([
            'subcategory_name'=>$request->subcategory_name,
            'category_id'=>$request->category_id,
            'subcategory_image'=> $file_name,
        ]);
        return back();
    }


}
//subcategory delete
    function subcategory_delete($subcategory_id){
        subcategory::find($subcategory_id)->delete();
        return back()->with('subcategory_del', 'Subcategory deleted successfully');
}
}
