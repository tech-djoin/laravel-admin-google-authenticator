<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>2FA Verification | {{ config('admin.title') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    @if(!is_null($favicon = Admin::favicon()))
        <link rel="shortcut icon" href="{{$favicon}}">
    @endif

    {!! Admin::css() !!}

    <style>
        .qr-code {
            text-align: center;
            margin-bottom: 20px;
        }
        .qr-code img {
            max-width: 200px;
            height: auto;
        }
        .login-page {
            background: #d2d6de;
        }
        .login-box {
            margin-top: 10%;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ admin_url('/') }}"><b>{{ config('admin.name') }}</b></a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Google Two-Factor Authentication</p>
        <p class="login-box-msg text-bold">{{ auth()->user()->name }}</p>
        <form id="2faFormVerify" action="{{ admin_url('2fa/verify') }}" method="post">
            <div class="form-group has-feedback {!! !$errors->has(config('google2fa.otp_input')) ?: 'has-error' !!}">
                @if($errors->has(config('google2fa.otp_input')))
                    @foreach($errors->get(config('google2fa.otp_input')) as $message)
                        <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i>{{$message}}</label><br>
                    @endforeach
                @endif
                <input type="text" class="form-control text-center" placeholder="Enter the 6-digit code Google Authenticator" name="{{config('google2fa.otp_input')}}" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4"></div>
                <div class="col-xs-4">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Verify</button>
                </div>
                <div class="col-xs-4"></div>
            </div>
        </form>
    </div>
</div>

<!-- jQuery 2.1.4 -->
<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ admin_asset("vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<script src="{{ admin_asset("vendor/laravel-admin/toastr/build/toastr.min.js")}}"></script>
<script>
    $(document).ready(function() {
        $('#2faFormVerify').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('button').prop('disabled', true);
                },
                success: function(response) {
                    window.location.href = "{{admin_url('/')}}";
                },
                error: function(response) {
                    if (response.responseJSON.message) {
                        let message = "";
                        $.each(response.responseJSON.message, function(k, v) {
                            message += v + '<br>';
                        });

                        toastr["error"](message);
                    }
                },
                complete: function() {
                    $('button').prop('disabled', false);
                }
            });
        });
    });
</script>
</body>
</html>