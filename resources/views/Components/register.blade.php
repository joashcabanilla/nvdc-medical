@extends('Layouts.Login')
@section('content')

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
                <h5><b>Register Here</b></h5>
                <h6 class="mb-4">Enter your credentials to access your account.</h6>

                <form id="loginForm" method="POST">
                    @csrf

                    {{-- Additional Fields --}}
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="First Name" name="first_name" required>
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
                        <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <textarea class="form-control" placeholder="Physical Address" name="address" rows="2" required></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-map-marker-alt"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="date" class="form-control" name="dob" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-calendar-alt"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block font-weight-bold">Register</button>
                    </div>

                    <div class="text-center mt-3">
                        <span>Don’t have an account yet? <a href="#" class="text-success font-weight-bold">Register</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
