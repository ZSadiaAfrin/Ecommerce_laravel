@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Inventory</a></li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>List of Inventory</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Sl</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($inventories as $sl=>$inventory )
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$inventory->rel_to_color->color_name}}</td>
                            <td>{{$inventory->size_id==null?'NA':$inventory->rel_to_size->size_name}}</td>
                            <td>{{$inventory->quantity}}</td>
                            <td><a href="{{route('inventory.delete',$inventory->id)}}" class="btn btn-danger">Delete</a></td>

                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3>Add Inventory</h3>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="" class="form-label">Product Name</label>
                            <input type="hidden" class="form-control" value="{{ $product_info->id }}" name="product_id">
                            <input type="text" class="form-control" readonly value="{{ $product_info->product_name }}"
                                name="product_name">
                        </div>
                        <div class="mb-3">
                            <label for="">Select Color</label>
                            <select name="color_id" id="" class="form-control">
                                <option value="">Select one</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Select Size</label>
                            <select name="size_id" id="" class="form-control">
                                <option value="">Select One</option>
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Quantitiy</label>
                            <input type="number" class="form-control" value="" name="quantity">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add inventory</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
