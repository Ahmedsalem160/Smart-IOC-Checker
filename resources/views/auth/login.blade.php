@extends('auth.app')

@section('auth-content')
    <div class="auth">
      <div class="auth-bg">
        <!-- Logo -->
        <div class="navbar-brand logo" href="/">
          <img src="{{asset('assets/images/logo.png')}}" />
          <span></span>
          <h1 class="font-weight-normal">IOC Checker</h1>
        </div>
      </div>
      <div class="auth-content">
        <div class="head">
          <h3>IOC Checker</h3>
          <p>Welcome back! Please login to your account.</p>
        </div>
        <form class="form" method="POST" action="{{route('login')}}">
            @csrf
          <div class="mb-3 form-input">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input
              required
              type="email"
              class="form-control"
              id="exampleInputEmail1"
              aria-describedby="emailHelp"
              name="email" autofocus
            />
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="mb-3 form-input">
            <label for="exampleInputPassword1" class="form-label"
              >Password</label
            >
            <input
              required
              minlength="4"
              type="password"
              name="password"
              class="form-control"
              id="exampleInputPassword1"
            />
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="remember-me">
            <div class="mb-3 form-check">
              <input
                type="checkbox"
                class="form-check-input"
                id="exampleCheck1"
              />
              <label class="form-check-label" for="exampleCheck1"
                >Remember me</label
              >
            </div>
            <a>Forget Password?</a>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
          <p class="account">
            D'ont havean account?
            <a href="{{route('custom-register')}}">Create an account</a>
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
