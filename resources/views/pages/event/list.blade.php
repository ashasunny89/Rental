@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

@include('users.partials.header', [
    'title' => __(''),
    'description' => __(''),
    'class' => 'col-lg-12'
])   
<div class="container-fluid mt--7">
<div class="row">
<div class="col-xl-10 mb-5 mb-xl-6">
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">List Events</h3>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Event</th>
                        <th scope="col">Date</th>
                        <th scope="col">Discription</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event as $key => $row)

                    <tr>
                        {{-- <td><strong>{{ ++$key }}</strong></td> --}}
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->event }}</td>
                        <td>{{ $row->date }}</td>
                        <td>{{ $row->discription }}</td>
                        <td>
                            <a href="#"  id="dropdownMenuLink" data-toggle="dropdown">
                            <img  width="10" src="{{ url('/assets/img/brand/list.png')}}">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ url('/event/edit/'.$row->id)}}">Edit</a>
                            <a class="dropdown-item" href="{{ url('eventdelete/'.$row->id)}}">Delete</a>
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