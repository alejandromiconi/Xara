<!-- @if (session('status') === 'password-updated')
<div class="alert alert-success">
    Password updated successfully!
</div>
@endif
 -->

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <x-error-messages />

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <x-text-input name="current_password" type="password"
            autocomplete="current-password" label="Current Password" />

        <x-text-input name="password" type="password"
            autocomplete="new-password" label="New Password" />

        <x-text-input name="password_confirmation" type="password"
            autocomplete="new-password" label="Password Confirmation" />

        <div class="flex items-center gap-4">
            
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Saved.') }}</p>

            @endif
        </div>
    </form>
</section>