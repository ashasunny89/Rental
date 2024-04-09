@extends('layouts.app')

@section('content')


    @include('users.partials.header', [
        'title' => __(''),
        'description' => __(''),
        'class' => 'col-lg-12'
    ])   
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-9 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h2 class="mb-0"><b>{{ __('Payment Details') }}</b></h2>
                        </div>
                    </div>



                    {{-- <form method="POST" action="{{ route('pages.reports.payment')}}">
                        @csrf
                        <label for="start_date">Start Date:</label>
                        <input type="date" name="start_date" required>
                        <label for="end_date">End Date:</label>
                        <input type="date" name="end_date" required>
                        <button type="submit">Search</button>
                    </form>
                    
                    @if(isset($dist))
                        <table>
                            <thead>
                                <tr>
                                    <th>District</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dist as $d)
                                    <tr>
                                        <td>{{ $d->district }}</td>
                                        <td>{{ $d->total_amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif --}}
                    


                    <div class="card-body">
                        <form method="POST" action="{{ route('pages.reports.payment') }}" autocomplete="off">
                            @csrf
                        
                            <div class="form-group row">
                                <label for="start_date" class="col-sm-2 col-form-label">{{ __('Start Date') }}</label>
                                <div class="col-sm-4">
                                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                                </div>
                            </div>
                        
                            <div class="form-group row">
                                <label for="end_date" class="col-sm-2 col-form-label">{{ __('End Date') }}</label>
                                <div class="col-sm-4">
                                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                                </div>
                            </div>
                        
                            <div class="form-group row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                                </div>
                            </div>
                       

                        @if(isset($districts))
                                <table class="table align-items-center table-flush">
                                    <thead>
                                        <tr>
                                            <th>District</th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($districts as $district)
                                            <tr>
                                                <td>{{ $district->district }}</td>
                                                <td>{{ $district->total_amount }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
@endsection
