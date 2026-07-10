<section>
    <p class="text-muted small mb-4">
        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
    </p>

    <!-- Trigger Button -->
    <button type="button" class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        Delete Account
    </button>

    <!-- Bootstrap 5 Confirm Deletion Modal -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title fw-bold" id="confirmUserDeletionModalLabel">Delete Account Permanently</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body py-2">
                        <p class="text-muted small mb-4">
                            Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                        </p>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="delete_password" class="form-label fw-bold text-muted small">Confirm Password</label>
                            <input 
                                id="delete_password" 
                                name="password" 
                                type="password" 
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                placeholder="Enter your password"
                                required
                            >
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback fw-semibold d-block mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Re-open modal if validation errors exist -->
    @if ($errors->userDeletion->isNotEmpty())
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const deleteModalEl = document.getElementById('confirmUserDeletionModal');
                    if (deleteModalEl && typeof bootstrap !== 'undefined') {
                        const deleteModal = new bootstrap.Modal(deleteModalEl);
                        deleteModal.show();
                    }
                });
            </script>
        @endpush
    @endif
</section>
