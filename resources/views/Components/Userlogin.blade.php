@extends('Layouts.Login')
@section('content')

 <div class="container-login hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <img src="{{asset('image/1.png')}}" alt="logo" width="250" />
                    <div class="alert alert-danger mt-2 mb-0 error-text d-none font-weight-bold" role="alert">
                        text message error
                    </div>
                </div>
                <div class="card-body">
                    <h5> 
                        <b>Login to Account</b> 
                        <h6>Enter Your credentials to access your account.</h6>
                    </h5>
                    <form id="loginForm" method="POST">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" id="username" name="username" autocomplete="false" required autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-0">
                            <input type="password" class="form-control" placeholder="Password" id="password" name="password" autocomplete="false" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row p-0 mt-1">
                            <div class="col-12">
                                <div class="icheck-success">
                                    <input type="checkbox" id="showPassword" name="showpassword">
                                    <label for="showPassword">Show password</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                             <div class="col-12 d-flex justify-content-center">
                              <button type="submit" class="btn btn-primary btn-block font-weight-bold w-75">Sign In</button>
                             </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection