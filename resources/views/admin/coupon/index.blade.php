@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Coupon</a></li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Coupon List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Coupon Name</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Expire date</th>
                            <th>Delete</th>
                        </tr>
                        @foreach ($coupons as $coupon )
                        <tr>
                            <td>{{$coupon->coupon_name}}</td>
                            <td>{{$coupon->type==1?'Percentage':'Fixed'}}</td>
                            <td>{{$coupon->amount}}</td>
                            <td>{{Carbon\Carbon::now()->diffInDays($coupon->expire_date,false)}}days remaining</td>
                            <td>
                                <a href="" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>

                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add new coupon</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('coupon.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" name="coupon_name" placeholder="coupon_name">
                        </div>
                        <div class="mb-3">
                            <select name="type" class="form-control">
                                <option value="">-Select Type-</option>
                                <option value="1">Percentage</option>
                                <option value="2">Fixed</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" name="amount" placeholder="Amount">
                        </div>
                        <div class="mb-3">
                            <input type="date" class="form-control" name="expire_date" placeholder="Expire_date">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add new coupon</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
