@extends('layouts.dashboard')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Category</a></li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-8 m-auto" >
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Edit Category</h6>
            </div>
            <div class="card-body">

                <form class="forms-sample" action="{{ route('category.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Category Name</label>
                        <input type="text" name="category_name" class="form-control" id="exampleInputUsername1"
                            autocomplete="off" value="{{$category_info->category_name}}">
                        @error('category_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Category image</label>
                        <input type="file" name="category_image" class="form-control" id="exampleInputUsername1"
                            autocomplete="off" placeholder="Username"onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            <div class="mt-2">
                                <img width="100"src="{{asset('uploads/category')}}/{{$category_info->category_image}}" id="blah" alt="">
                            </div>
                            @error('category_image')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <input type="hidden" name="category_id" value="{{$category_info->id}}">
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection()
