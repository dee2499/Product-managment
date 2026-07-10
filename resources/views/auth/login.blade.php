<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <p class="login-box-msg text-muted text-center mb-4">Sign in to access your dashboard</p>

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <div class="input-group">
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    class="form-control @error('email') is-invalid @enderror" 
                    placeholder="Email" 
                    required 
                    autofocus 
                    autocomplete="username"
                >
                <div class="input-group-text">
                    <span class="bi bi-envelope"></span>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <div class="input-group">
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    class="form-control @error('password') is-invalid @enderror" 
                    placeholder="Password" 
                    required 
                    autocomplete="current-password"
                >
                <div class="input-group-text">
                    <span class="bi bi-lock-fill"></span>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Row: Remember & Submit -->
        <div class="row align-items-center mb-3">
            <div class="col-8">
                <div class="form-check">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        name="remember" 
                        class="form-check-input"
                    >
                    <label class="form-check-label text-muted small" for="remember_me">
                        Remember Me
                    </label>
                </div>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
            </div>
        </div>
    </form>

    <p class="mb-1 text-center mt-4">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-decoration-none small text-indigo">
                Forgot password?
            </a>
        @endif
    </p>
    <p class="mb-0 text-center">
        @if (Route::has('register'))
            <span class="text-muted small">Don't have an account? </span>
            <a href="{{ route('register') }}" class="text-decoration-none small fw-bold">
                Sign Up
            </a>
        @endif
    </p>
</x-guest-layout>
