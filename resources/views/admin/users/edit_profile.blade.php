@extends('layouts.dashboard')
@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Edit Profile</h6>
            </div>
            <div class="card-body">

                <form class="forms-sample" action="{{route('update.profile.info')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Name</label>
                        <input type="text" class="form-control" name="name" id="exampleInputUsername1" autocomplete="off"
                            value="{{Auth::User()->name}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="{{Auth::User()->email}}">
                    </div>


                    <button type="submit" class="btn btn-primary mr-2">Update Profile</button>

                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Update Password</h6>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif

                <form class="forms-sample" action="{{route('update.password')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Old Password</label>
                        <input type="password" class="form-control" name="old_password" id="exampleInputUsername1" autocomplete="off" >
                        @error('old_password')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        @if (session('old_wrong'))
                        <strong class="text-danger">{{session('old_wrong')}}</strong>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">New Password</label>
                        <input type="password" class="form-control" name="password" id="exampleInputUsername1" autocomplete="off" >
                        @error('password')
                        <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" id="exampleInputUsername1" autocomplete="off" >
                    </div>
                    @error('password_confirmation')
                    <strong class="text-danger">{{$message}}</strong>
                    @enderror


                    <button type="submit" class="btn btn-primary mr-2">Update Password</button>

                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Update Profile Photo</h6>
            </div>
            <div class="card-body">
                    @if (session('success_photo'))
                    <div class="alert alert-success">{{session('success_photo')}}</div>
                    @endif
                <form class="forms-sample" action="{{route('update.profile.photo')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Photo</label>
                        <input type="file" class="form-control" name="photo" id="exampleInputUsername1" autocomplete="off" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            @error('photo')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        <div class="my-2">
                        <img src="" id="blah" width="100" alt="">
                        </div>
                    </div>



                    <button type="submit" class="btn btn-primary mr-2">Update Profile Photo</button>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection()
