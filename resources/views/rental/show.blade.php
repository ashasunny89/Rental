<!-- resources/views/rentals/show.blade.php -->

@extends('layouts.app', ['title' => __('Rental Details')])

@section('content')

@include('users.partials.header', [
    'title' => __('Rental Details'),
    'description' => __('View rental details.'),
    'class' => 'col-lg-12'
])   

<div class="container-fluid mt--7">
    <div class="row justify-content-center">
        <div class="col-xl-6 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Rental Details</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <tr>
                                <th scope="row">ID</th>
                                <td>{{ $rental->id }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Customer Name</th>
                                <td>{{ $rental->customer_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Customer Address</th>
                                <td>{{ $rental->customer_address }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Customer phone1</th>
                                <td>{{ $rental->phone1 }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Customer phone2</th>
                                <td>{{ $rental->phone2 }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-lg-12">
            <h3 class="mb-4">Suit Pieces Rented</h3>
            <ul>
                @foreach ($rental->suitPieces as $suitPiece)
                    <li>{{ $suitPiece->name }} ({{ $suitPiece->size }}) - {{ $suitPiece->pivot->price }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@include('layouts.footers.auth')

</div>
@endsection
