<x-guest-layout>

<x-error-messages />
  <div class="login-page bg-body-secondary">

    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Register</p>

          <form method="POST" action="{{ route('register') }}">
            @csrf

            <x-text-input label="Name" name="name" class="block mt-1 w-full" :value="old('name')" required autofocus autocomplete="name" />
            <x-text-input label="E-Mail" name="email" class="block mt-1 w-full" type="email" :value="old('email')" required autocomplete="username" />

            <x-text-input label="Password" name="password" class="block mt-1 w-full"
              type="password"
              name="password"
              required autocomplete="new-password" />

            <x-text-input label="Password confirmation"
              name="password_confirmation" class="block mt-1 w-full"
              type="password"
              name="password_confirmation" required autocomplete="new-password" />


            <div class="flex items-center justify-end mt-4">
              <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
              </a>

              <x-primary-button class="ms-4">
                {{ __('Register') }}
              </x-primary-button>
            </div>


          </form>

        </div>
        <!-- /.login-card-body -->
      </div>
    </div>

  </div>

  <!--end::OverlayScrollbars Configure-->
  <!--end::Script-->

</x-guest-layout>