@extends('layouts.dashboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Category</a></li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Edit SubCategory</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('subcategory.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-lebel">Add New Subcategory</label>
                        <input type="text" class="form-control" name="subcategory_name" value="{{$subcategory_info->subcategory_name}}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-lebel">Select Category</label>
                        <select name="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"  {{$subcategory_info->category_id == $category->id?'selected':''}}>{{ $category->category_name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">SubCategory Image</label>
                        <input type="file" name="subcategory_image" class="form-control" id="exampleInputUsername1"
                            autocomplete="off" placeholder="SubCategory Image"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            <img src="{{asset('uploads/subcategory')}}/{{$subcategory_info->subcategory_image}}" width="100" id="blah" alt="">

                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="subcategory_id" value="{{$subcategory_info->id}}">
                        <button type="submit" class="btn btn-primary">Update subcategory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
