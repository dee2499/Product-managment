<x-guest-layout>
    <p class="login-box-msg text-muted text-center mb-4">Register a new catalog account</p>

    <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <div class="input-group">
                <input 
                    id="name" 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}" 
                    class="form-control @error('name') is-invalid @enderror" 
                    placeholder="Full Name" 
                    required 
                    autofocus 
                    autocomplete="name"
                >
                <div class="input-group-text">
                    <span class="bi bi-person"></span>
                </div>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

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
                    autocomplete="new-password"
                >
                <div class="input-group-text">
                    <span class="bi bi-lock-fill"></span>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <div class="input-group">
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    class="form-control" 
                    placeholder="Confirm Password" 
                    required 
                    autocomplete="new-password"
                >
                <div class="input-group-text">
                    <span class="bi bi-lock-fill"></span>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary w-100 py-2">Register</button>

        <div class="text-center mt-4">
            <span class="text-muted small">Already registered? </span>
            <a href="{{ route('login') }}" class="text-decoration-none small fw-bold">
                Log In
            </a>
        </div>
    </form>
</x-guest-layout>
