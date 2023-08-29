@extends('frontend.master')
@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Login Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="mb-3">
                    <h3>Login</h3>
                </div>
                @if(session('verify_success'))
                <div class="alert alert-success">{{session('verify_success')}}</div>
                @endif
                @if(session('not_verified'))
                <div class="alert alert-danger float-flex">{{session('not_verified')}} <a style="float:right;margin-right: -21px;margin-top: -13px" class="btn btn-success " href="{{route('send.emailverify.req')}}">Send Verify Request</a> </div>
                @endif
                @if (session('wrong'))
                    <div class="alert alert-danger">{{session('wrong')}}</div>
                @endif
                @if (session('login'))
                <div class="alert alert-danger">{{session('login')}}</div>
            @endif
                <form class="border p-3 rounded" action="{{route('customer.login')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="text" name="email" class="form-control" placeholder="Email*">
                    </div>

                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" name="password" class="form-control" placeholder="Password*">
                    </div>

                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="eltio_k2">
                                <a href="{{route('forgot.password')}}">Lost Your Password?</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
                    </div>
                    <div class="form-group">
                        <a type="submit" href="{{route('github.redirect')}}" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login With Github</a>
                    </div>
                    <div class="form-group">
                        <a type="submit" href="{{route('google.redirect')}}" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login With Google</a>
                    </div>
                    <div class="form-group">
                        <a type="submit" href="{{route('facebook.redirect')}}" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login With Facebook</a>
                    </div>
                </form>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mfliud">
                <div class="mb-3">
                    <h3>Register</h3>
                </div>
                @if(session('verify'))
                    <div class="alert alert-success">{{session('verify')}}</div>
                @endif


                <form class="border p-3 rounded" action="{{route('customer.register.store')}}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Full Name *</label>
                            <input name="name" type="text" class="form-control" placeholder="Full Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email *</label>
                        <input name="email" type="text" class="form-control" placeholder="Email*">
                        @error('email')
                            <div class="alert alert-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Password *</label>
                            <input name="password" type="password" class="form-control" placeholder="Password*">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Confirm Password *</label>
                            <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password*">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Create An Account</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<!-- ======================= Login End ======================== -->

@endsection
