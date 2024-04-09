@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

@include('users.partials.header', [
    'title' => __(''),
    'description' => __(''),
    'class' => 'col-lg-12'
])   
<div class="container-fluid mt--7">
<div class="row">
<div class="col-xl-12 mb-5 mb-xl-6">
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">List Notifications</h3>
                    
                </div>
               
            </div>
        </div>
        <div class="table-responsive">
            <!-- Projects table -->
            @if(Session::has('delete'))
            <div class="alert alert-success" role="alert">
                {{Session::get('delete')}}
            </div>
            @endif
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Position Nmae</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Address</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($directory as $key => $direct)
                            <tr>
                                {{-- <td><strong>{{ ++$key }}</strong></td> --}}
                                <td>{{ $direct->id }}</td>
                                <td>{{ $direct->positionname }}</td>
                                <td>{{ $direct->name }}</td>
                                <td><img src="{{ asset($direct->image) }}" alt="Image" width="100"></td>
                                <td>{{ $direct->address }}</td>
                                <td>{{ $direct->phone }}</td>
                                <td>{{ $direct->email }}</td>
                                <td>
                                    <a href="#"  id="dropdownMenuLink" data-toggle="dropdown">
                                    <img  width="10" src="{{ url('/assets/img/brand/list.png')}}">
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{ url('/directory-edit/'.$direct->id)}}">Edit</a>
                                    <a class="dropdown-item" href="{{ url('/directory-delete/'.$direct->id)}}">Delete</a>
                                    </div>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
        </div>
    </div>
</div>
</div>
@include('layouts.footers.auth')
</div>
@endsection