@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Product List</a></li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Product List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>After Discount</th>
                            <th>Preview</th>
                            <th>Action</th>
                        </tr>
                        @foreach ( $all_products as  $all_product)
                        <tr>
                            <td>{{ $all_product->product_name}}</td>
                            <td>&#2547; {{ $all_product->price}}</td>
                            <td>{{ $all_product->discount==null ? '0' : $all_product->discount}}%</td>
                            <td>{{ $all_product->after_discount}}</td>
                            <td><img src="{{asset('uploads/product/preview/')}}/{{ $all_product->preview}}" alt=""></td>
                            <td >

                                    <a class=" btn btn-success btn-icon   text-white" href="{{route('product.inventory',$all_product->id)}}"><i data-feather="layers"></i></a>

                                <button type="button" class="btn btn-primary btn-icon">
                                    <a class="text-white" href="{{route('product.edit',$all_product->id)}}"><i data-feather="edit"></i></a>
                                </button>

                                {{-- <button type="button" class="btn btn-danger btn-icon show-alert-delete-box" data-toggle="tooltip">
                                    <a class=""  href="{{route('product.delete',$all_product->id)}}"> <i data-feather="trash"></i></a>


                                </button> --}}
                        <form method="POST" action="{{ route('product.delete', $all_product->id) }}" class="d-inline">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn  btn-danger  show-alert-delete-box btn-icon delete_btn  " data-toggle="tooltip" title='Delete'> <i data-feather="trash"></i></button>
                        </form>
                            </td>
{{--btn-flat btn-sm --}}
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_script')

<script type="text/javascript">
    $('.show-alert-delete-box').click(function(event){
        var form =  $(this).closest("form");
        var name = $(this).data("name");
         event.preventDefault();
        swal({
            title: "Are you sure you want to delete this record?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            type: "warning",
            buttons: ["Cancel","Yes!"],
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((willDelete) => {
            if (willDelete) {
                form.submit();
            }
        });




    })

</script>




@endsection
