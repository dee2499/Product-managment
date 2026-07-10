<section>
    <p class="text-muted small mb-4">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>

    <form method="post" action="{{ route('password.update') }}" class="needs-validation" novalidate>
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label fw-bold text-muted small">{{ __('Current Password') }}</label>
            <input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                autocomplete="current-password"
                @error('current_password', 'updatePassword') aria-describedby="current_password-error" @enderror
            >
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback fw-semibold" id="current_password-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label fw-bold text-muted small">{{ __('New Password') }}</label>
            <input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                autocomplete="new-password"
                @error('password', 'updatePassword') aria-describedby="password-error" @enderror
            >
            @error('password', 'updatePassword')
                <div class="invalid-feedback fw-semibold" id="password-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label fw-bold text-muted small">{{ __('Confirm Password') }}</label>
            <input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                autocomplete="new-password"
                @error('password_confirmation', 'updatePassword') aria-describedby="password_confirmation-error" @enderror
            >
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback fw-semibold" id="password_confirmation-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit -->
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-4">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <span class="text-success small fw-bold"><i class="bi bi-check-circle-fill me-1"></i>{{ __('Saved.') }}</span>
            @endif
        </div>
    </form>
</section>
