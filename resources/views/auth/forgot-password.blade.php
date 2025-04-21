<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="login-page bg-body-secondary">

        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <x-text-input type="email" name="email" placeholder="E-Mail"
                            :value="old('email')"
                            required autofocus>
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </x-text-input>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Email Password Reset Link</button>
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