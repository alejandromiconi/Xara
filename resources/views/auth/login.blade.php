<x-guest-layout>
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <x-error-messages />

  <div class="login-page bg-body-secondary">

    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>

          <form method="POST" action="{{ route('login') }}">
            @csrf

            <x-text-input type="email" name="email" placeholder="E-Mail">
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </x-text-input>

            <x-text-input type="password" name="password" placeholder="Password">
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </x-text-input>

            <!--begin::Row-->
            <div class="row">
              <div class="col-8">
                <x-text-input type="checkbox" name="flexCheckDefault" label="Remember Me" />
              </div>
              <!-- /.col -->
              <div class="col-4">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </form>

          <!--
          <div class="social-auth-links text-center mb-3 d-grid gap-2">
            <p>- OR -</p>
            <a href="#" class="btn btn-primary">
              <i class="bi bi-facebook me-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-danger">
              <i class="bi bi-google me-2"></i> Sign in using Google+
            </a>
          </div>
          -->

          <!-- /.social-auth-links -->
          <p class="mb-1">
            <a href="{{ route('password.request') }}"> I forgot my password </a>
          </p>

          <p class="mb-0">
            <a href="{{ route('register') }}" class="text-center"> Register a new membership </a>
          </p>

        </div>
        <!-- /.login-card-body -->
      </div>
    </div>

  </div>

  <!--end::OverlayScrollbars Configure-->
  <!--end::Script-->

</x-guest-layout>