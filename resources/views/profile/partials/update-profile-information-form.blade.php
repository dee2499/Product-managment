<section>
    <p class="text-muted small mb-4">
        {{ __("Update your account's profile information and email address.") }}
    </p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
        @csrf
        @method('patch')

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-bold text-muted small">{{ __('Name') }}</label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name"
                @error('name') aria-describedby="name-error" @enderror
            >
            @error('name')
                <div class="invalid-feedback fw-semibold" id="name-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="form-label fw-bold text-muted small">{{ __('Email Address') }}</label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username"
                @error('email') aria-describedby="email-error" @enderror
            >
            @error('email')
                <div class="invalid-feedback fw-semibold" id="email-error">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-warning small">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" class="btn btn-link btn-sm p-0 align-baseline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-2 text-success fw-semibold">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Submit -->
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-4">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small fw-bold"><i class="bi bi-check-circle-fill me-1"></i>{{ __('Saved.') }}</span>
            @endif
        </div>
    </form>
</section>
