@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => __(''),
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
                            <h2 class="mb-0"><b>{{ __('Meet Link') }}</b></h2>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form method="post" action="{{ route('link-add') }}" autocomplete="off">
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
                                        <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Link Title') }}</label>
                                            <input type="text" name="title" id="input-event" 
                                                class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('MeetTitle') }}" required autofocus>

                                            @if ($errors->has('title'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('link') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-email">{{ __('Meeting Link') }}</label>
                                            <input type="text" name="link" id="input-discription" 
                                                class="form-control form-control-alternative{{ $errors->has('link') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('Link') }}" value="{{ old('link') }}" required>

                                            @if ($errors->has('link'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('link') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 md-2">
                                                <div class="form-group{{ $errors->has('start_datetime') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-start-datetime">{{ __('Start Date and Time') }}</label>
                                                    <input type="datetime-local" name="start_datetime" id="input-start-datetime" 
                                                    class="form-control form-control-alternative{{ $errors->has('start_datetime') ? ' is-invalid' : '' }}" 
                                                    value="{{ old('start_datetime') }}" required autofocus>

                                                    @if ($errors->has('start_datetime'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('start_datetime') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6 md-2">
                                                <div class="form-group{{ $errors->has('end_datetime') ? ' has-danger' : '' }}">
                                                    <label class="form-control-label" for="input-start-datetime">{{ __('End Date and Time') }}</label>
                                                    <input type="datetime-local" name="end_datetime" id="input-start-datetime" 
                                                    class="form-control form-control-alternative{{ $errors->has('end_datetime') ? ' is-invalid' : '' }}" 
                                                    value="{{ old('end_datetime') }}" required autofocus>

                                                    @if ($errors->has('end_datetime'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('end_datetime') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
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
