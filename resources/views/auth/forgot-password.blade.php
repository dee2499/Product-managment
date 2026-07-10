<x-guest-layout>
    <div class="mb-4 text-muted small text-center">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                class="form-control input-focus-gradient @error('email') is-invalid @enderror" 
                placeholder="name@example.com" 
                required 
                autofocus
            >
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('login') }}" class="text-decoration-none small text-muted">
                &larr; Back to Login
            </a>
            <button type="submit" class="btn gradient-btn py-2">
                Send Reset Link
            </button>
        </div>
    </form>
</x-guest-layout>
