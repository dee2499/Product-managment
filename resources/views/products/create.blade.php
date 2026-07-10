<x-app-layout>
    <x-slot name="header">
        <h3 class="mb-0">Create Product</h3>
    </x-slot>

    <!-- Custom validation border overlay style for TinyMCE on errors -->
    @error('description')
        @push('styles')
            <style>
                .tox-tinymce {
                    border-color: #dc3545 !important;
                    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
                }
            </style>
        @endpush
    @enderror

    <div class="row">
        <div class="col-12 col-lg-10 mx-auto">
            <!-- AdminLTE Card -->
            <div class="card card-primary card-outline shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
                    <h3 class="card-title fw-bold m-0"><i class="bi bi-plus-circle-fill me-2 text-primary"></i>New Product Specifications</h3>
                    <div class="card-tools ms-auto">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold">
                            &larr; Back to Catalog
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('products.store') }}" id="productCreateForm" novalidate>
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold text-muted small">Product Title</label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                value="{{ old('title') }}" 
                                class="form-control py-2.5 @error('title') is-invalid @enderror" 
                                placeholder="Enter a descriptive title" 
                                required 
                                autofocus
                                @error('title') aria-describedby="title-error" @enderror
                            >
                            @error('title')
                                <div class="invalid-feedback fw-semibold" id="title-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Price and Date Available -->
                        <div class="row g-4 mb-4">
                            <div class="col-12 col-md-6">
                                <label for="price" class="form-label fw-bold text-muted small">Price ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        name="price" 
                                        id="price" 
                                        value="{{ old('price') }}" 
                                        class="form-control py-2.5 @error('price') is-invalid @enderror" 
                                        placeholder="0.00" 
                                        required
                                        @error('price') aria-describedby="price-error" @enderror
                                    >
                                    @error('price')
                                        <div class="invalid-feedback fw-semibold d-block" id="price-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="date_available" class="form-label fw-bold text-muted small">Date Available</label>
                                <input 
                                    type="date" 
                                    name="date_available" 
                                    id="date_available" 
                                    value="{{ old('date_available') }}" 
                                    class="form-control py-2.5 @error('date_available') is-invalid @enderror" 
                                    required
                                    @error('date_available') aria-describedby="date_available-error" @enderror
                                >
                                @error('date_available')
                                    <div class="invalid-feedback fw-semibold" id="date_available-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description (TinyMCE Rich Text) -->
                        <div class="mb-5">
                            <label for="description" class="form-label fw-bold text-muted small">Product Description</label>
                            <textarea 
                                name="description" 
                                id="description" 
                                class="form-control @error('description') is-invalid @enderror" 
                                rows="8" 
                                placeholder="Enter detailed product description..."
                                @error('description') aria-describedby="description-error" @enderror
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback fw-semibold d-block mt-2" id="description-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <a href="{{ route('products.index') }}" class="btn btn-light py-2.5 px-4 fw-semibold">Cancel</a>
                            <button type="submit" class="btn btn-primary py-2.5 px-4" id="submitBtn">
                                <i class="bi bi-save me-1.5"></i>Create Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Load TinyMCE Rich Text Editor -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                tinymce.init({
                    selector: '#description',
                    plugins: 'lists link code table wordcount',
                    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | code',
                    height: 350,
                    branding: false,
                    promotion: false,
                    skin: isDarkMode ? 'oxide-dark' : 'oxide',
                    content_css: isDarkMode ? 'dark' : 'default',
                    content_style: `
                        body { 
                            font-family: 'Source Sans 3', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
                            font-size: 15px; 
                            line-height: 1.6; 
                            padding: 12px;
                        }
                    `,
                    setup: function (editor) {
                        editor.on('change', function () {
                            tinymce.triggerSave();
                        });
                    }
                });

                // Add loading spinner and disable submit buttons to prevent double submission
                const form = document.getElementById('productCreateForm');
                const submitBtn = document.getElementById('submitBtn');
                if (form && submitBtn) {
                    form.addEventListener('submit', function() {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1.5" role="status" aria-hidden="true"></span>Saving...';
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
