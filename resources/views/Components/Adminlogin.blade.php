@extends('Layouts.Login')
@section('content')

<div class="container-login hold-transition login-page">
    <div class="login-box" style="width: 420px;"> {{-- Slightly wider --}}
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="{{ asset('image/1.png') }}" alt="logo" width="250" />
                <div class="alert alert-danger mt-2 mb-0 error-text d-none font-weight-bold" role="alert">
                    text message error
                </div>
            </div>
            <div class="card-body">
                <h5><b>Login to Account</b></h5>
                <h6 class="mb-5">Enter your credentials to access your account.</h6>

                <form id="loginForm" method="POST">
                    @csrf

                    {{-- Username field - cleaned up --}}
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" id="username" name="username" required autofocus>
                    </div>

                    {{-- Password field with eye icon (no background) --}}
                    <div class="input-group mb-2">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text bg-transparent border-left-0">
                                <span class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Forgot Password link --}}
                    <div class="form-group text-right">
                        <a href="Forgot Password" class="text-secondary font-weight-bold">Forgot Password?</a>
                    </div>

                    {{-- Submit button --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block font-weight-bold">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Optional JS for toggling password visibility --}}
@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const password = document.getElementById('password');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>
@endpush

@endsection
