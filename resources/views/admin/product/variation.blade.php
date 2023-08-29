@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Product Variation</a></li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Color List</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        @if (session('success_delete'))
                        <strong class="alert alert-success">{{session('success_delete')}}</strong>
                         @endif
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>

                            <th>Color Name</th>
                            <th>Color </th>
                            <th>Action</th>
                        </tr>
                        @foreach ($colors as  $sl=>$color)
                        <tr>
                            <td>{{$sl+1}}</td>

                            <td>{{$color->color_name}}</td>
                            {{-- <td><span class="badge" style="background:{{$color->color_code}};color:transparent;">primary</span></td> --}}

                            @if($color->color_code==null){

                            <td><span>no color</span></td>}

                            @else{
                                <td><span class="badge"     style="background-color:{{$color->color_code
                                }} ;color:transparent">Primary</span></td>
                            }
                            @endif
                            <td><a href="{{route('color.delete',$color->id)}}" class="btn btn-danger">Delete</a></td>

                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header">
                    <h3 class="text-center">Size List</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        @if (session('success'))
                            <strong class="alert alert-success">{{session('success')}}</strong>
                        @endif
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Category</th>
                            <th>Size Name</th>

                            <th>Action</th>
                        </tr>
                        @foreach ($sizes as  $sl=>$size)
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$size->category_id==null?'NA':$size->rel_to_cat->category_name}}</td>
                            <td>{{$size->size_name}}</td>
                            <td><a href="{{route('size.delete',$size->id)}}" class="btn btn-danger">Delete</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h4>Add Color Variation</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('variation.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-lebel">Color Name</label>
                            <input type="text" class="form-control" name="color_name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-lebel">Color Code</label>
                            <input type="text" class="form-control" name="color_code">
                        </div>

                        <button name="btn" value="1" type="submit" class="btn btn-primary">Add Color</button>
                    </form>

                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header">
                    <h4>Add Size Variation</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('variation.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="" class="form-lebel">Size Name</label>
                            <select name="category_id" id="" class="form-control" value="">
                                <option value="">Select One</option>
                                @foreach ($categories as $category )
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-lebel">Size Name</label>
                            <input type="text" class="form-control" name="size_name">
                        </div>
                        <button name="btn" value="2" type="submit" class="btn btn-primary">Add size</button>
                    </form>

                </div>
            </div>
        </div>
    </div>




{{-- new try for inventory veriation what should we do in our life life is so much pain full what we should do in our daily life we have do something do in our life , --}}

<div class="row my-5">
    @foreach ($categories as $category)


        <div class="col-lg-6 mt-3">
            <div class="card">
                <div class="card-header">
                <h3>{{$category->category_name}}</h3>
                </div>
                <div class="card-body">
                <table class="table table-bordered">
                <tr>
                    <th>Sl</th>
                    <th>Size Name</th>
                    <th>Action</th>
                </tr>
                @foreach (App\Models\Size::where('category_id',$category->id)->get() as $sl=> $size)


                <tr>
                    <td>{{$sl+1}}</td>

                    <td>{{$size->size_name}}</td>

                    <td><a href="{{route('size.delete',$size->id)}}" class="btn btn-danger">Delete</a></td>
                </tr>
                @endforeach
                </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
