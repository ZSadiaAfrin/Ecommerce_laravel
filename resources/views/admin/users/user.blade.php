@extends('layouts.dashboard')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h3>User List <span class="float-right">Total User:{{$total_users-1}}</span></h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>created_at</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($users as $SL =>$user)
                                <tr>
                                    <td>{{ $SL + 1 }}</td>
                                    <td>
                                        @if ($user->photo==null)
                                        <img src="{{ Avatar::create($user->name)->toBase64() }}"/>
                                        @else
                                        <img src="{{asset('uploads/user')}}/{{$user->photo}}" alt="profile">
                                        @endif
                                    </td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    {{-- <td>{{$user->created_at->format('d-m-y h:i:s')}}</td> --}}
                                    <td>{{$user->created_at->diffForHumans()}}</td>
                                    <td><a href="{{route('user.delete',$user->id)}}" class="btn btn-danger">Delete</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
