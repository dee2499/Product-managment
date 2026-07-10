<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{
    /**
     * Search and paginate products.
     */
    public function searchAndPaginate(
        ?string $keyword,
        string $sortBy = 'created_at',
        string $sortOrder = 'desc',
        int $perPage = 10
    ): LengthAwarePaginator;

    /**
     * Get products structured for DataTables server-side processing.
     *
     * @return array{total: int, filtered: int, data: Collection}
     */
    public function getForDataTable(
        ?string $search,
        string $orderBy,
        string $orderDir,
        int $start,
        int $length
    ): array;

    /**
     * Find a product by ID.
     */
    public function find(int $id): ?Product;

    /**
     * Create a new product.
     */
    public function create(array $data): Product;

    /**
     * Update an existing product.
     */
    public function update(Product $product, array $data): Product;

    /**
     * Delete a product.
     */
    public function delete(Product $product): bool;
}
