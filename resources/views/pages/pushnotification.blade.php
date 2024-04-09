@extends('layouts.app', ['title' => __('User Profile')])

@section('content')

    @include('users.partials.header', [
        'title' => __('') ,
        'description' => __(''),
        'class' => 'col-lg-12'
    ])

    @if(Session::has('success'))
              <p class="alert alert-success" style="background-color: #4CAF50; color: white;">{{ Session::get('success') }}</p>
          @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-9 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h2 class="mb-0"><b>{{ __('Push Notification') }}</b></h2>
                        </div>
                    </div>
                    <div class="card-body">
                       
                        <form method="post" action="{{ route('sendPush') }}" autocomplete="off">
                            @csrf
                            <!-- <h6 class="heading-small text-muted mb-4">{{ __(' information') }}</h6> -->
                            
                            
                            <div class="pl-lg-4">
                                <div class="row">     
                                    <div class="col-lg-12 md-2">                        
                                    <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Title') }}</label>
                                        <input type="text" name="title" id="input-name" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="{{ old('title')}}" required autofocus>

                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('message') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-email">{{ __('Message') }}</label>
                                        <textarea type="text" name="message" id="input-message" class="form-control form-control-alternative{{ $errors->has('message') ? ' is-invalid' : '' }}" placeholder="{{ __('Message') }}" value="{{ old('message') }}" required></textarea>

                                        @if ($errors->has('message'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('message') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Send Notification') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    <br>
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- <center>
                <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
            </center> -->
            <!-- <br>
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
  
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
  
                    <form action='send-push-notification' method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" name="body"></textarea>
                          </div>
                        <button type="submit" class="btn btn-primary">Send Notification</button>
                    </form>
  
                </div>
            </div>
        </div>
    </div>
</div>
  
<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>

{{-- <script>

var firebaseConfig = {
    "type": "service_account",
    "project_id": "redcross-b58cb",
    "private_key_id": "365d8cf2333b75b738bd56c7a4dfeed6977d99b3",
    "private_key": "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCh5fLjcgMEdt56\nQqwas99ncF7QbeVDjZCr/QTuvra0g9yu5QUC4rFXWsX7nKJKZAICpbAqDH3hl4e4\ny4w3uY3G5xyDd5dbs7fgRapT9X+U8jXPr38WALwo3rD1vK95IZB4OQNyVTflB/F7\nycjcbhNUH8gI6Wzuiv7AoN8zWF9e3Bos9JlzgytxG37OLrsQvVXRUTNyfJi6/Wxb\nOIbVqEPOEB3kIkw80AnevNMlJzG4smqei3qzCB2zc573VSj3vEfbtP1teirkWXAK\nMjoXUGB9MNRvOA/TYDJT9hbvazX7rkZv3dt1r2bUcpnuSUSI6ZAIlydfKt4L0kM7\n1694WtS9AgMBAAECggEASzw4iPDpLRBuaAOGxivztDaYoSSIx8FIS1ycB7Sx5CZp\nDg+YqhQd1Jn26mwKUSazdnZ37Lp8XzMTW9Gfmh/NHnM1IXUYbgGRABRvyG+MN/Pt\nBNQp61gxGI8QTko+gzyRTgU0sFOg03rDAkMt6B3xNoVEaLvNJveJ1ouL3ekB/Orv\nllpMq67690U0gwSXVi2xiRvNEiFjVnr6uucRaAekL+cHsRBSnPRRMPUUuOz9/uha\nGY3q2BIEfsUIBiILf7pp9GCCsbE2OrLJGuNsu8j6d3m7hFV/5e6XHlvnOR3x3NIQ\nyWeF1cYiJR7blJjdt965LmBcOSsFCI9prlYkFzWQAwKBgQDTiLoOTT4FOiNHaODf\nqMqFUf6BhNAaKohojMK4ye2WP77vDzB97FxkC5MBhV0IFTQKilhF4LoIjm96bwMH\nYP4Ylx+sPLDSRh8XJv4cauHFRz7P76u1KlrXChP1a1N1mhV99vXiPjP90n/10oXt\nHGVyoGu7cVb3YCmzA7vaQwLk8wKBgQDD7iuhsqxu4lf9F4RQjMcg0MennGl3sZgL\nO+IWuqjz4+tEZEQUWSkgMEmzPvMv9vwPw17f9STEm2syyploAnIqhTtavwQcclMl\nTNveGXTcurl1t+VRdOFjXe5Fs8+BLkJyeluUUg6WHVzt9QjB43pzu5EFQdybkJv9\nl5Ygyh+LjwKBgQDC6VIeyXejU12cd/v0uk/ZpqKu7xTdd2F3jHQD1zRPZG9nUYSq\nEvdSzANpvFvrjbYFHFKYGKjyJ2R62P1eeDXJrL5ncwiuyCPvrmMpBicAI1SyPrHl\n3aAUUtnvIjSlwROanMsV66D2eVakyJXU1Hx5sW1zKs0qZXYm2ALo6yQolwKBgHP/\nPbWtoojDWHRux9cogXvcH1gMMiS679k2ytPKDtzVwyPqeKPTZZW5AOkuC6wJ/ZEX\nicPtzqbXnM+lQs1hJVYnKsy+6iAtTyx2JHWJfLZxlfsrtIhVOlsp8TczDVbdnFlK\nN43IRvp4x9vZhiXEF2sNUP5bz9AJ/VBVvnwLLkHhAoGBAIV+etodFuVJ5HY2+q13\nUYJvVMjSw7zoCpbYJQdo3a+WX8f4o8GrqqqlnVKM4TNtXgzBYbvJ5rsGkyULIoiT\nedViagXUoYUj4maSFj2RB1tUJZbfzZbNzTRbks2sliEto5GhDP2+zjCMhuMdLH9A\nqXU+yRQsf/QhpOWLJXDPIUvx\n-----END PRIVATE KEY-----\n",
    "client_email": "firebase-adminsdk-r171o@redcross-b58cb.iam.gserviceaccount.com",
    "client_id": "103326590370500394367",
    "auth_uri": "https://accounts.google.com/o/oauth2/auth",
    "token_uri": "https://oauth2.googleapis.com/token",
    "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
    "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-r171o%40redcross-b58cb.iam.gserviceaccount.com",
    "universe_domain": "googleapis.com"
  };
</script> --}}

 {{-- <script>
  
    var firebaseConfig = {
      "type": "service_account",
      "project_id": "redcross-b58cb",
      "private_key_id": "365d8cf2333b75b738bd56c7a4dfeed6977d99b3",
      "private_key": "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCh5fLjcgMEdt56\nQqwas99ncF7QbeVDjZCr/QTuvra0g9yu5QUC4rFXWsX7nKJKZAICpbAqDH3hl4e4\ny4w3uY3G5xyDd5dbs7fgRapT9X+U8jXPr38WALwo3rD1vK95IZB4OQNyVTflB/F7\nycjcbhNUH8gI6Wzuiv7AoN8zWF9e3Bos9JlzgytxG37OLrsQvVXRUTNyfJi6/Wxb\nOIbVqEPOEB3kIkw80AnevNMlJzG4smqei3qzCB2zc573VSj3vEfbtP1teirkWXAK\nMjoXUGB9MNRvOA/TYDJT9hbvazX7rkZv3dt1r2bUcpnuSUSI6ZAIlydfKt4L0kM7\n1694WtS9AgMBAAECggEASzw4iPDpLRBuaAOGxivztDaYoSSIx8FIS1ycB7Sx5CZp\nDg+YqhQd1Jn26mwKUSazdnZ37Lp8XzMTW9Gfmh/NHnM1IXUYbgGRABRvyG+MN/Pt\nBNQp61gxGI8QTko+gzyRTgU0sFOg03rDAkMt6B3xNoVEaLvNJveJ1ouL3ekB/Orv\nllpMq67690U0gwSXVi2xiRvNEiFjVnr6uucRaAekL+cHsRBSnPRRMPUUuOz9/uha\nGY3q2BIEfsUIBiILf7pp9GCCsbE2OrLJGuNsu8j6d3m7hFV/5e6XHlvnOR3x3NIQ\nyWeF1cYiJR7blJjdt965LmBcOSsFCI9prlYkFzWQAwKBgQDTiLoOTT4FOiNHaODf\nqMqFUf6BhNAaKohojMK4ye2WP77vDzB97FxkC5MBhV0IFTQKilhF4LoIjm96bwMH\nYP4Ylx+sPLDSRh8XJv4cauHFRz7P76u1KlrXChP1a1N1mhV99vXiPjP90n/10oXt\nHGVyoGu7cVb3YCmzA7vaQwLk8wKBgQDD7iuhsqxu4lf9F4RQjMcg0MennGl3sZgL\nO+IWuqjz4+tEZEQUWSkgMEmzPvMv9vwPw17f9STEm2syyploAnIqhTtavwQcclMl\nTNveGXTcurl1t+VRdOFjXe5Fs8+BLkJyeluUUg6WHVzt9QjB43pzu5EFQdybkJv9\nl5Ygyh+LjwKBgQDC6VIeyXejU12cd/v0uk/ZpqKu7xTdd2F3jHQD1zRPZG9nUYSq\nEvdSzANpvFvrjbYFHFKYGKjyJ2R62P1eeDXJrL5ncwiuyCPvrmMpBicAI1SyPrHl\n3aAUUtnvIjSlwROanMsV66D2eVakyJXU1Hx5sW1zKs0qZXYm2ALo6yQolwKBgHP/\nPbWtoojDWHRux9cogXvcH1gMMiS679k2ytPKDtzVwyPqeKPTZZW5AOkuC6wJ/ZEX\nicPtzqbXnM+lQs1hJVYnKsy+6iAtTyx2JHWJfLZxlfsrtIhVOlsp8TczDVbdnFlK\nN43IRvp4x9vZhiXEF2sNUP5bz9AJ/VBVvnwLLkHhAoGBAIV+etodFuVJ5HY2+q13\nUYJvVMjSw7zoCpbYJQdo3a+WX8f4o8GrqqqlnVKM4TNtXgzBYbvJ5rsGkyULIoiT\nedViagXUoYUj4maSFj2RB1tUJZbfzZbNzTRbks2sliEto5GhDP2+zjCMhuMdLH9A\nqXU+yRQsf/QhpOWLJXDPIUvx\n-----END PRIVATE KEY-----\n",
      "client_email": "firebase-adminsdk-r171o@redcross-b58cb.iam.gserviceaccount.com",
      "client_id": "103326590370500394367",
      "auth_uri": "https://accounts.google.com/o/oauth2/auth",
      "token_uri": "https://oauth2.googleapis.com/token",
      "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
      "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-r171o%40redcross-b58cb.iam.gserviceaccount.com",
      "universe_domain": "googleapis.com"
    };
      
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
  
    function initFirebaseMessagingRegistration() {
            messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);
   
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
  
                $.ajax({
                    url: '{{ route("save-token") }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Token saved successfully.');
                    },
                    error: function (err) {
                        console.log('User Chat Token Error'+ err);
                    },
                });
  
            }).catch(function (err) {
                console.log('User Chat Token Error'+ err);
            });
     }  
      
    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });
   
</script>  --}} --> 

@endsection 