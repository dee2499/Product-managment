<x-app-layout>
    <x-slot name="header">
        <h3 class="mb-0">Product Details</h3>
    </x-slot>

    <div class="row">
        <!-- Main details card -->
        <div class="col-12 col-lg-8 mb-4">
            <div class="card card-primary card-outline shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
                    <h3 class="card-title fw-bold m-0"><i class="bi bi-file-earmark-text-fill me-2 text-primary"></i>Description</h3>
                    <div class="card-tools ms-auto">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold">
                            &larr; Back to Catalog
                        </a>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <h2 class="h3 fw-bold mb-4">{{ $product->title }}</h2>

                    <!-- Rich Text Description -->
                    <div class="product-description text-secondary lh-lg mb-0">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Attributes panel -->
        <div class="col-12 col-lg-4">
            <div class="card card-outline card-secondary shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-info-circle-fill me-2 text-muted"></i>Specifications</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <span class="text-muted small fw-bold d-block text-uppercase">Price</span>
                        <span class="fs-2 fw-bold text-primary">${{ number_format((float) $product->price, 2) }}</span>
                    </div>

                    <div class="mb-4">
                        <span class="text-muted small fw-bold d-block text-uppercase">Availability Date</span>
                        <span class="fw-bold fs-5">{{ $product->date_available->format('F d, Y') }}</span>
                        @if($product->date_available->isFuture())
                            <div class="mt-1">
                                <span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill small fw-bold">
                                    Upcoming
                                </span>
                            </div>
                        @else
                            <div class="mt-1">
                                <span class="badge bg-success px-2.5 py-1 rounded-pill small fw-bold">
                                    Available Now
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="mb-4 pt-3 border-top border-light">
                        <span class="text-muted small fw-semibold d-block">Added On</span>
                        <span class="text-muted">{{ $product->created_at->format('M d, Y H:i') }}</span>
                    </div>

                    @if(Auth::user()->isAdmin())
                        <div class="d-grid gap-2 pt-3 border-top border-light">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary py-2.5 fw-semibold">
                                <i class="bi bi-pencil-fill me-1.5"></i>Edit Product
                            </a>
                            <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger py-2.5 fw-semibold w-100">
                                    <i class="bi bi-trash-fill me-1.5"></i>Delete Product
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
