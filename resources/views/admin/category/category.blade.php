@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Category</a></li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-header">
                    <h6>Category List</h6>
                </div>
                <div class="card-body">
                    @if (session('delete_success'))
                        <div class="alert alert-success">{{ session('delete_success') }}</div>
                    @endif
                    <form action="{{route('check.delete')}}" method="POST">
                        @csrf
                        <table class="table table-bordered">
                            <tr>
                                <th><input type="checkbox" id="chkAllcat">Check All</th>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Category Image</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($categories as $sl => $category)
                                <tr>
                                    <td><input type="checkbox" class="category" name="category_id[]"
                                            value="{{ $category->id }}"></td>
                                    <td>{{ $sl + 1 }}</td>
                                    <td>{{ $category->category_name }}</td>
                                    <td><img width="70"
                                            src="{{ asset('uploads/category/') }}/{{ $category->category_image }}"
                                            alt=""></td>
                                    <td>
                                        <div class="dropdown mb-2">
                                            <button class="btn p-0" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                <a class="dropdown-item d-flex align-items-center"
                                                    href="{{ route('category.edit', $category->id) }}"><i
                                                        data-feather="edit-2" class="icon-sm mr-2"></i> <span
                                                        class="">Edit</span></a>

                                                <a class="dropdown-item d-flex align-items-center"
                                                    href="{{ route('category.delete', $category->id) }}"><i
                                                        data-feather="trash" class="icon-sm mr-2"></i> <span
                                                        class="">Delete</span></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="mt-3">
                            <button type="submit"  class="btn btn-danger d-none del_btn">Deleted Checkbox</button>
                        </div>
                    </form>



                </div>
            </div>

            @if ($trash_categories->count() >= 1)
            <form action="{{route('check.restore')}}" method="POST">
                @csrf
                <div class="card mt-5">
                    <div class="card-header">
                        <h4>Trash Category List</h4>
                    </div>
                    <div class="card-body">
                        @if (session('permanent_delete_success'))
                            <div class="alert alert-success">{{ session('permanent_delete_success') }}</div>
                        @endif
                        <table class="table table-bordered">
                            <tr>
                                <th><input type="checkbox" id="chkAllcatre">Check all</th>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Category Image</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($trash_categories as $sl => $category)
                                <tr>
                                    <td><input type="checkbox" class="categoryre" name="category_id[]"
                                        value="{{ $category->id }}"></td>
                                    <td>{{ $sl + 1 }}</td>
                                    <td>{{ $category->category_name }}</td>
                                    <td><img width="70"
                                            src="{{ asset('uploads/category/') }}/{{ $category->category_image }}"
                                            alt=""></td>
                                    <td>
                                        <div class="dropdown mb-2">
                                            <button class="btn p-0" type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                <a class="dropdown-item d-flex align-items-center"
                                                    href="{{ route('category.restore', $category->id) }}"><i
                                                        data-feather="edit-2" class="icon-sm mr-2"></i> <span
                                                        class="">Restore</span></a>

                                                <a class="dropdown-item d-flex align-items-center"
                                                    href="{{ route('category.del', $category->id) }}"><i
                                                        data-feather="trash" class="icon-sm mr-2"></i> <span
                                                        class="">Delete Permanent</span></a>


                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success"> Restore Checked</button>
                    <button type="submit" class="btn btn-danger"><a class="text-white" href="{{route('checkper.del',$category->id)}}">Deleted Checked permanently</a></button>
                </div>
            </form>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Add Category</h6>
                </div>
                <div class="card-body">

                    <form class="forms-sample" action="{{ route('category.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Category Name</label>
                            <input type="text" name="category_name" class="form-control" id="exampleInputUsername1"
                                autocomplete="off" placeholder="Username">
                            @error('category_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Category image</label>
                            <input type="file" name="category_image" class="form-control" id="exampleInputUsername1"
                                autocomplete="off" placeholder="Username">
                            @error('category_image')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_script')
    <script>
        $("#chkAllcat").on('click', function() {
            $(".del_btn").toggleClass('d-none');
            this.checked ? $(".category").prop("checked", true) : $(".category").prop("checked", false);
        })
        $(".category").on('click', function() {
            $(".del_btn").toggleClass('d-none');

        })
    </script>
    <script>
        $("#chkAllcatre").on('click', function() {
            this.checked ? $(".categoryre").prop("checked", true) : $(".categoryre").prop("checked", false);
        })
    </script>
@endsection
