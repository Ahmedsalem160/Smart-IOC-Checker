@extends('auth.app')

@section('auth-content')
<body>
    <div class="auth">
      <div class="auth-bg">
        <!-- Logo -->
        <div class="navbar-brand logo" href="/">
          <img src="{{asset('assets/images/logo.png')}}" />
          <span></span>
          <h1 class="font-weight-normal">IOC Checker</h1>
        </div>
      </div>
      <div class="auth-content register">
        <div class="head">
          <h3>New Account</h3>
          <p>Please complate to create an account.</p>
        </div>
        <form class="form" action="{{route('register')}}" method="POST">
            @csrf
          <div class="d-flex gap-3">
            <!-- <div class="mb-3 form-input">
              <label for="firstname" class="form-label">First Name</label>
              <input required type="text" class="form-control" id="firstname" />
            </div>
            <div class="mb-3 form-input">
              <label for="lastname" class="form-label">last Name</label>
              <input required type="text" class="form-control" id="lastname" />
            </div> -->
          </div>
          <div class="mb-3 form-input">
            <label for="username" class="form-label">Username</label>
            <input required type="text" name="name" class="form-control" id="username" />
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <!-- <div class="mb-3 form-input">
            <label for="phone" class="form-label">Phone</label>
            <input
              required
              type="number"
              class="form-control"
              id="phone"
              minlength="11"
            />
          </div> -->
          <div class="mb-3 form-input">
            <label for="email"  class="form-label">Email</label>
            <input required type="email" name="email" class="form-control" id="email" />
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="mb-3 form-input">
            <label for="regster-password" class="form-label">Password</label>
            <input
              required
              minlength="4"
              type="password"
              class="form-control"
              id="regster-password"
              name="password"
            />
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="mb-3 form-input">
            <label for="confirmpassword" class="form-label"
              >Confirm Password</label
            >
            <input
              required
              minlength="4"
              type="password"
              class="form-control"
              id="confirmpassword"
              name="password_confirmation"
            />
            <p id="error-message" style="color: red"></p>
          </div>
          <div class="remember-me">
            <div class="mb-3 form-check">
              <input
                type="checkbox"
                class="form-check-input"
                id="exampleCheck1"
                checked
              />
              <label class="form-check-label" for="exampleCheck1">
                I agree to all terms and conditions</label
              >
            </div>
          </div>
          <button type="submit" id="register-btn" class="btn btn-primary">
            Sign Up
          </button>
          <p class="account">
            Already have an account?
            <a href="{{route('custom-login')}}">Login</a>
          </p>
        </form>
      </div>
    </div>
    <!-- <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script> -->
@endsection

