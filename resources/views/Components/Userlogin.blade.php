@extends('Layouts.Login')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container-login hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{ asset('image/1.png') }}" alt="logo" width="250" />
                <div class="alert alert-danger mt-2 mb-0 error-text d-none font-weight-bold" role="alert">
                    text message error
                </div>
            </div>
            <div class="card-body">
                <h5><b>Login to Account</b></h5>
                <h6 class="mb-4">Enter your credentials to access your account.</h6>

                <form id="loginForm2" method="POST" action="{{ route('user.postLogin') }}">

                    @csrf
            
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" required autofocus>
                    </div>

                    <div class="input-group mb-2">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-eye-slash" id="togglePassword" style="cursor: pointer; transition: 0.2s;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <a href="#" class="text-secondary font-weight-bold">Forgot Password?</a>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block font-weight-bold">Sign In</button>
                    </div>

                    <div class="text-center mt-3">
                        <span>Don’t have an account yet? <a href="{{ route('user.register') }}" class="text-success font-weight-bold">Register</a></span>
                        <hr style="margin: 1rem 0; border-top: 1px solid #ccc;" />
                        <a href="#" class="text-primary font-weight-bold" style="cursor:pointer;">Check Application Status</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
