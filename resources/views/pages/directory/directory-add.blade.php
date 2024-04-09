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
                            <h2 class="mb-0"><b>{{ __('Directory') }}</b></h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('directoryadd') }}" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">{{ __('Directory Information') }}</h6>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-12 md-2">
                                        <div class="form-group{{ $errors->has('committe') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-committee">{{ __('Committee') }}</label>
                                            <select name="committe" id="input-committee" class="form-control form-control-alternative{{ $errors->has('committe') ? ' is-invalid' : '' }}" required>
                                                @foreach ($committees as $committe)
                                                    <option value="{{ $committe->committe }}">{{ $committe->committe }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('committe'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('committe') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <!-- Position Name Field -->
                                        <div class="form-group{{ $errors->has('positionname') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-position">{{ __('Position') }}</label>
                                            <input type="text" name="positionname" id="input-position" class="form-control form-control-alternative{{ $errors->has('positionname') ? ' is-invalid' : '' }}" placeholder="{{ __('Position Name') }}" required autofocus>
                                            @if ($errors->has('positionname'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('positionname') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Name Field -->
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" required autofocus>
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Image Field -->
                                        <div class="form-group{{ $errors->has('image') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-image">{{ __('Image') }}</label>
                                            <input type="file" name="image" id="input-image" class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}" accept="image/*" required>
                                            @if ($errors->has('image'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('image') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Address Field -->
                                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-address">{{ __('Address') }}</label>
                                            <textarea type="text" name="address" id="input-address" class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Address') }}" required></textarea>
                                            @if ($errors->has('address'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Phone Field -->
                                        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                            <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}" required>
                                            @if ($errors->has('phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Email Field -->
                                        <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                            <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" required>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('priority') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-priority">{{ __('Priority') }}</label>
                                            <select name="priority" id="input-priority" class="form-control form-control-alternative{{ $errors->has('priority') ? ' is-invalid' : '' }}" required>
                                                <option value="high">High</option>
                                                <option value="medium">Medium</option>
                                                <option value="low">Low</option>
                                            </select>
                                            @if ($errors->has('priority'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('priority') }}</strong>
                                                </span>
                                            @endif
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
