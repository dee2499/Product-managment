<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    /**
     * ProductService constructor.
     */
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected HtmlSanitizer $htmlSanitizer
    ) {}

    /**
     * Search and paginate products.
     */
    public function searchAndPaginate(
        ?string $keyword,
        string $sortBy = 'created_at',
        string $sortOrder = 'desc',
        int $perPage = 10
    ): LengthAwarePaginator {
        return $this->productRepository->searchAndPaginate($keyword, $sortBy, $sortOrder, $perPage);
    }

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
    ): array {
        return $this->productRepository->getForDataTable($search, $orderBy, $orderDir, $start, $length);
    }

    /**
     * Find a product by ID.
     */
    public function find(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    /**
     * Create a new product with sanitized rich text.
     */
    public function create(array $data): Product
    {
        if (isset($data['description'])) {
            $data['description'] = $this->htmlSanitizer->sanitize($data['description']);
        }

        return $this->productRepository->create($data);
    }

    /**
     * Update an existing product with sanitized rich text.
     */
    public function update(Product $product, array $data): Product
    {
        if (isset($data['description'])) {
            $data['description'] = $this->htmlSanitizer->sanitize($data['description']);
        }

        return $this->productRepository->update($product, $data);
    }

    /**
     * Delete a product.
     */
    public function delete(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }
}
