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
                <a class="btn bg-gradient-white  mx-3" href="{{('suits.create')}}">
                    <i class="material-icons text-sm"></i>&nbsp;&nbsp;Add New User
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
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Suit Title</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                      <tbody>
                        @foreach ($suitPieces as $suitPiece)
                        <tr>
                            <td>{{ $suitPiece->id }}</td>
                            <td>{{ $suitPiece->name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('suit_pieces.edit', $suitPiece->id) }}">Edit</a>
                                        <a class="dropdown-item" href="{{ route('suit_pieces.destroy', $suitPiece->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $suitPiece->id }}').submit();">Delete</a>
                                        <form id="delete-form-{{ $suitPiece->id }}" action="{{ route('suit_pieces.destroy', $suitPiece->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
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
@endsection