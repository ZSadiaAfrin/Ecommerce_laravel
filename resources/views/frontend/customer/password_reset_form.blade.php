@extends('frontend.master')
@section('content')
    <div class="cotainer">
        <div class="row my-5">
            <div class="col-lg-4 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Password Reset</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                        <form action="{{route('password.reset.confirm')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-level">New Password</label>
                                <input type="hidden" class="form-control" name="token" value="{{$token}}">
                                <input type="password" class="form-control" name="password" value="" >

                            </div>
                            <div class="mb-3">
                                <label for="" class="form-level">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" value="">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
