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
                            <h2 class="mb-0"><b>{{ __('User Payment Details') }}</b></h2>
                        </div>
                    </div>


                    <div class="card-body">
                        <form method="POST" action="{{ route('pages.reports.user')}}" autocomplete="off">
                            @csrf

                            <h6 class="heading-small text-muted mb-4">{{ __('Total payment') }}</h6>
                            <div class="pl-lg-4">
                                <div class="table-responsive"> 
                                    <!-- Projects table -->
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                {{-- <th scope="col">S.No</th> --}}
                                                <th scope="col">User Name</th>
                                                <th scope="col">Payment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($results as $row)
                                                <tr>
                                                    <th>{{ $row->user_name }}</th>
                                                    <th>{{  $row->total_amount }}</th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
@endsection
