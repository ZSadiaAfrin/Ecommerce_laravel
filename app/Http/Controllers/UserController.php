<?php

namespace App\Http\Controllers;

use App\Http\Requests\UseePassUpdate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;

class UserController extends Controller
{
    function users()
    {

        $users = User::where('id', '!=', Auth::id())->get();
        $total_users = User::count();

        return view('admin.users.user', compact('users', 'total_users'));
    }
    function user_delete($user_id)
    {
        User::find($user_id)->delete();
        return back()->with('success', 'User Deleted Successfully');
    }
    function user_edit()
    {
        return view('admin.users.edit_profile');

    }
    function user_profile_update(Request $request)
    {
        User::find(Auth::id())->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return back();
    }
    function user_password_update(UseePassUpdate $request)
    {

        if (Hash::check($request->old_password, Auth::user()->password)) {

            User::find(Auth::id())->update([

                'password' => bcrypt($request->password)
            ]);
            return back()->with('success', 'Your password updated successfully!');
        } else {

            return back()->with('old_wrong', 'Your password does not match');
        }
    }
    function user_photo_update(Request $request)
    {

        $request->validate([
            'photo' => ['required', 'mimes:jpg,bmp,png'],
            'photo' => 'file|max:512',
        ]);

        $prev_photo = public_path('uploads/user/'.Auth::user()->photo);
        unlink($prev_photo);

        $upload_photo = $request->photo;
        $extension= $upload_photo->getClientOriginalExtension();
        $file_name = Auth::id() . '.' . $extension;

        Image::make($upload_photo)->save(public_path('uploads/user/'.$file_name));
        User::find(Auth::id())->update([
        'photo'=>$file_name,

        ]);
        return back()->with('success_photo', 'Your photo updated successfully');
    }
}
