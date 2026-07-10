<x-guest-layout>
    <h3 class="fw-bold mb-4 text-center">Reset Password</h3>

    <form method="POST" action="{{ route('password.store') }}" novalidate>
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email', $request->email) }}" 
                class="form-control input-focus-gradient @error('email') is-invalid @enderror" 
                placeholder="name@example.com" 
                required 
                autofocus 
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">New Password</label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                class="form-control input-focus-gradient @error('password') is-invalid @enderror" 
                placeholder="••••••••" 
                required 
                autocomplete="new-password"
            >
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
            <input 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                class="form-control input-focus-gradient" 
                placeholder="••••••••" 
                required 
                autocomplete="new-password"
            >
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn gradient-btn w-100 py-2.5">
            Reset Password
        </button>
    </form>
</x-guest-layout>
