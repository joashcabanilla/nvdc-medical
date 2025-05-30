@extends('Layouts.Login')
@section('content')

<div class="container-login hold-transition login-page mt-5">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{ asset('image/1.png') }}" alt="logo" width="250" />
                <div class="alert alert-danger mt-2 mb-0 error-text d-none font-weight-bold" role="alert">
                    text message error
                </div>
            </div>
            <div class="card-body">
                <h5><b>Register Here</b></h5>
                <h6 class="mb-4">Enter your credentials to access your account.</h6>

                <form id="registrationForm" method="POST" action="{{ route('user.postRegister') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="First Name" name="first_name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Middle Name" name="middle_name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Last Name" name="last_name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" name="username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="tel" class="form-control" placeholder="Contact Number" name="contact_number" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-eye-slash" id="togglePassword" style="cursor: pointer; transition: 0.2s;"></i>
                            </div>
                        </div>
                    </div>

                  

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block font-weight-bold">Register</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
