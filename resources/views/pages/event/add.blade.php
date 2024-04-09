@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

    @include('users.partials.header', [
        'title' => __('') ,
        'description' => __(''),
        'class' => 'col-lg-12'
    ])
    <br>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-9 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h2 class="mb-0"><b>{{ __('Events') }}</b></h2>
                        </div>
                    </div>
                    <div class="card-body">
                       
                        <form method="post" action="{{ route('pages.event.add')}}" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif


                            <div class="pl-lg-4">
                                <div class="row">     
                                    <div class="col-lg-12 md-2">                        
                                    <div class="form-group{{ $errors->has('event') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Event') }}</label>
                                        <input type="text" name="event" id="input-event" class="form-control form-control-alternative{{ $errors->has('event') ? ' is-invalid' : '' }}" placeholder="{{ __('Event') }}" required autofocus>

                                        @if ($errors->has('event'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('event') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('date') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-date">{{ __('Date') }}</label>
                                        <input type="date" name="date" id="input-name" class="form-control form-control-alternative{{ $errors->has('date') ? ' is-invalid' : '' }}" placeholder="{{ __('Notification Date') }}" value="{{ old('date') }}" required autofocus>

                                        @if ($errors->has('date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('discription') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-email">{{ __('Message') }}</label>
                                    <textarea type="text" name="discription" id="input-discription" class="form-control form-control-alternative{{ $errors->has('discription') ? ' is-invalid' : '' }}" placeholder="{{ __('Discription') }}" value="{{ old('discription') }}" required></textarea>

                                    @if ($errors->has('discription'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('discription') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
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
