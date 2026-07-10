<x-guest-layout>
    <div class="mb-4 text-muted small text-center">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" novalidate>
        @csrf

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                class="form-control input-focus-gradient @error('password') is-invalid @enderror" 
                placeholder="••••••••" 
                required 
                autocomplete="current-password"
            >
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn gradient-btn w-100 py-2.5">
            Confirm Password
        </button>
    </form>
</x-guest-layout>
