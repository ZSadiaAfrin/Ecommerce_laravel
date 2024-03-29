@extends('layouts.dashboard')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Category</a></li>
    </ol>
</nav>

<form action="{{route('product.update')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h3>Edit  product</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <input type="hidden" name="product_id" value="{{$product_info->id}}">
                    <div class="mb-3">
                        <label for="" class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="product_name" value="{{$product_info->product_name}}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="" class="form-label">Product Price</label>
                        <input type="number" class="form-control" name="price" value="{{$product_info->price}}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="" class="form-label">Product Discount</label>
                        <input type="number" class="form-control" name="discount" value="{{$product_info->discount}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Select Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">--Select Any--</option>
                            @foreach ($categories as $category)
                                <option  {{ $category->id == $product_info->category_id?'selected':' '}} value="{{$category->id}}">{{ $category->category_name }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Select Sub Category</label>
                        <select name="subcategory_id" id="subcategory" class="form-control">
                            <option value="">--Select Any--</option>
                            @foreach ($subcategories as $subcategory)
                                <option {{$subcategory->id == $product_info->subcategory_id?'selected':' '}}  value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="" class="form-label">Product Brand</label>
                        <select name="brand"  class="form-control">
                            <option value="">--Select Any--</option>
                            @foreach ($brands as $brand)
                                <option {{$brand->id == $product_info->brand?'selected':' '}} value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label for="" class="form-label">Short Description</label>
                        <input type="text" class="form-control" name="short_desp" value="{{$product_info->short_desp}}">

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="" class="form-label" >Long Description</label>
                        <textarea id="summernote" name="long_desp"  value="">{{$product_info->long_desp}}</textarea>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="" class="form-label">Additional Information</label>
                        <textarea id="summernote1" name="additional_info"  value="">{{$product_info->additional_info}}</textarea>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Product Preview</label>
                        <input type="file" class="form-control" name="preview">
                        <div class="my-2">
                            <img width="200" src="{{asset('uploads/product/preview')}}/{{$product_info->preview}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Product Gallery</label>
                        <input type="file" multiple class="form-control" name="gallery[]">
                        <div class="my-2">
                            @foreach ( $gallery_images as  $gallery)
                            <img width="200" src="{{asset('uploads/product/gallery')}}/{{ $gallery->gallery}}" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 m-auto">
                    <div class="mb-3 mt-5 ">
                        <button type="submit" class="btn btn-primary form-control">Add Product</button>
                    </div>
                </div>
            </div>
        </div>
</form>


@endsection
@section('footer_script')
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    })
</script>
<script>
    $(document).ready(function() {
        $('#summernote1').summernote();
    })
</script>
@endsection
