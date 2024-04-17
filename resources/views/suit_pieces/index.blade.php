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
        @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
        <div class="table-responsive">
           
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Item Title</th>
                                <th scope="col">Item Size</th>
                                <th scope="col">Item Price</th>
                                <th scope="col">Item Available</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($suitPieces as $suitPiece)
                        <tr>
                            <td>{{ $suitPiece->id }}</td>
                            <td>{{ $suitPiece->name }}</td>
                            <td>{{ $suitPiece->size }}</td>
                            <td>{{ $suitPiece->price }}</td>
                            <td> <input type="checkbox" name="available" id="available" value="1" {{ $suitPiece->available == 1 ? 'checked' : '' }} disabled> </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('suit_pieces.edit', $suitPiece->id) }}">Edit</a>
                                        <form id="delete-form-{{ $suitPiece->id }}" action="{{ route('suit_pieces.destroy', $suitPiece->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <a class="dropdown-item" onclick="confirmDelete({{ $suitPiece->id }})">
                                                Delete
                                            </button>
                                        </form>
                                        
                                    </div>
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
<script>
    function confirmDelete(suitPieceId) {
        if (confirm('Are you sure you want to delete this item?')) {
            document.getElementById('delete-form-' + suitPieceId).submit();
        }
    }
</script>
@endsection