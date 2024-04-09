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
            <div class="container">
                <h2>Edit Suit Piece</h2>
                @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                <form method="POST" action="{{ route('suit_pieces.update', $suitPiece->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" value="{{ $suitPiece->name}}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="size">Size:</label>
                        <input type="text" name="size" id="size" value="{{ $suitPiece->size}}"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="size">Price:</label>
                        <input type="text" name="price" id="price" value="{{ $suitPiece->price}}"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="available">Available:</label>
                        <input type="hidden" name="available" value="0"> <!-- Hidden input field to submit 0 if checkbox is unchecked -->
                        <input type="checkbox" name="available" id="available" value="1" {{ $suitPiece->available == 1 ? 'checked' : '' }}>                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@include('layouts.footers.auth')
</div>
<script>
    $('#available').change(function() {
        if ($(this).is(':checked')) {
            $('input[name="available"]').val(1);
        } else {
            $('input[name="available"]').val(0);
        }
    });
@endsection