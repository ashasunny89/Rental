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
                            <h2 class="mb-0"><b>{{ __('Banner') }}</b></h2>
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

                        <form method="post" action="{{ route('sponsor-add') }}" enctype="multipart/form-data" autocomplete="off">
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
                                        <div class="form-group{{ $errors->has('banner_title') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Banner Title') }}</label>
                                            <input type="text" name="banner_title" id="input-event" 
                                                class="form-control form-control-alternative{{ $errors->has('banner_title') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('MeetTitle') }}" required autofocus>

                                            @if ($errors->has('banner_title'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('banner_title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('banner_image') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-image">{{ __('Banner Image') }}</label>
                                            <input type="file" name="banner_image" id="input-image" 
                                                class="form-control form-control-alternative{{ $errors->has('banner_image') ? ' is-invalid' : '' }}" accept="image/*" required>
                                            @if ($errors->has('banner_image'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('banner_image') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
