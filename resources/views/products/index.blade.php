<x-app-layout>
    @push('styles')
        <!-- DataTables Bootstrap 5 CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" crossorigin="anonymous" />
        <style>
            /* Custom alignment to blend DataTables controls with AdminLTE theme card */
            .dataTables_wrapper .dataTables_length {
                padding: 1rem 1.25rem 0.5rem;
            }
            .dataTables_wrapper .dataTables_filter {
                padding: 1rem 1.25rem 0.5rem;
            }
            .dataTables_wrapper .dataTables_info {
                padding: 1rem 1.25rem;
                font-size: 0.875rem;
            }
            .dataTables_wrapper .dataTables_paginate {
                padding: 1rem 1.25rem;
            }
            /* Custom Search alignment */
            .dataTables_filter input {
                border-radius: 4px;
                border: 1px solid #ced4da;
                padding: 0.375rem 0.75rem;
                margin-left: 0.5rem;
            }
            .dataTables_filter input:focus {
                border-color: #80bdff;
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }
        </style>
    @endpush

    <x-slot name="header">
        <h3 class="mb-0">Product Catalog</h3>
    </x-slot>

    <!-- AdminLTE Card for Product Table -->
    <div class="card card-primary card-outline shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2 py-3">
            <h3 class="card-title fw-bold m-0"><i class="bi bi-list-stars me-2 text-primary"></i>Catalog Items</h3>
            <div class="card-tools ms-auto">
                @can('create', App\Models\Product::class)
                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1.5 fw-semibold px-3 py-1.5">
                        <i class="bi bi-plus-lg"></i>Add New Product
                    </a>
                @endcan
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="productsTable" class="table table-hover align-middle mb-0 w-100">
                    <thead class="text-muted small uppercase">
                        <tr>
                            <th scope="col" class="ps-4 py-3">Product Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Available Date</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamically populated via AJAX DataTable -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Load jQuery first (required for DataTables) -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
        <!-- DataTables Core & Bootstrap 5 Integration -->
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $('#productsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('products.index') }}",
                        type: "GET",
                        error: function (xhr, error, code) {
                            console.error("DataTables AJAX error: ", error, code, xhr.responseText);
                        }
                    },
                    columns: [
                        { data: 'title', name: 'title', orderable: true, className: 'ps-4' },
                        { data: 'description', name: 'description', orderable: false },
                        { data: 'price', name: 'price', orderable: true },
                        { data: 'date_available', name: 'date_available', orderable: true },
                        { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end pe-4' }
                    ],
                    order: [[0, 'asc']], // Order by title ascending by default
                    pageLength: 10,
                    lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
                    language: {
                        searchPlaceholder: "Search title or description...",
                        search: "Search:",
                        processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
