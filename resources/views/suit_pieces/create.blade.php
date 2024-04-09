<!-- resources/views/suites/create.blade.php -->


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
                <a class="btn bg-gradient-white  mx-3" href="{{route('suit_pieces.create')}}">
                    <i class="material-icons text-sm"></i>&nbsp;&nbsp;Add New Item
                </a>
            </div>
        </div>
       
        <div class="table-responsive">
            <!-- Projects table -->
            @if(Session::has('delete'))
            <div class="alert alert-success" role="alert">
                {{Session::get('delete')}}
            </div>
            @endif
            @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
            @endif
            <div class="container">
                <h2>Add Suit Piece</h2>
                <form action="{{ route('suit_pieces.store') }}" method="POST">
                    @csrf
                    <div class="pl-lg-4">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="size">Size:</label>
                            <input type="text" name="size" id="size" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="available">Available:</label>
                            <input type="checkbox" name="available" id="available" value="1">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Add Suit Piece</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@include('layouts.footers.auth')
</div>
@endsection