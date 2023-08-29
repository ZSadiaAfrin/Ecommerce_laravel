@extends('frontend.master')
@section('content')
    <div class="cotainer">
        <div class="row my-5">
            <div class="col-lg-4 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Email Verify Request</h3>
                    </div>
                    <div class="card-body">
                        @if (session('invalid'))
                            <div class="alert alert-danger">{{ session('invalid') }}</div>
                        @endif
                        @if (session('verify'))
                            <div class="alert alert-success">{{ session('verify') }}</div>
                        @endif
                        @if (session('register'))
                            <div class="alert alert-danger">{{ session('register') }}</div>
                        @endif

                        <form action="{{ route('email.verify.req.send') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-level">Your Email Addrss</label>
                                <input type="text" class="form-control" name="email" value="">
                                @error('email')
                                    <strong class="text-danger">{{ $messages }}</strong>
                                @enderror

                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Send Request</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
