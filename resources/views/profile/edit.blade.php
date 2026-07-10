<x-app-layout>
    <x-slot name="header">
        <h3 class="mb-0">{{ __('My Account') }}</h3>
    </x-slot>

    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            <!-- Profile Info Card -->
            <div class="card card-primary card-outline shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title m-0 fw-bold"><i class="bi bi-person-circle me-2 text-primary"></i>Profile Information</h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Card -->
            <div class="card card-primary card-outline shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title m-0 fw-bold"><i class="bi bi-shield-lock-fill me-2 text-primary"></i>Update Password</h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="card card-danger card-outline shadow-sm mb-4">
                <div class="card-header py-3">
                    <h5 class="card-title m-0 fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Delete Account</h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Global form loading spinner feedback script for profile forms
                document.querySelectorAll('form').forEach(form => {
                    // Skip verification send forms
                    if (form.id === 'send-verification') return;

                    form.addEventListener('submit', function() {
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1.5" role="status" aria-hidden="true"></span>Saving...';
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
