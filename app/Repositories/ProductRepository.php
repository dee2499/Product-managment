<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Search and paginate products with sorting support.
     */
    public function searchAndPaginate(
        ?string $keyword,
        string $sortBy = 'created_at',
        string $sortOrder = 'desc',
        int $perPage = 10
    ): LengthAwarePaginator {
        $allowedSorts = ['title', 'price', 'date_available', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSorts, true) ? $sortBy : 'created_at';
        $sortOrder = in_array(strtolower($sortOrder), ['asc', 'desc'], true) ? strtolower($sortOrder) : 'desc';

        $query = Product::query();

        if ($keyword !== null && trim($keyword) !== '') {
            $monthNameNumber = $this->resolveMonthName($keyword);
            $query->where(function ($q) use ($keyword, $monthNameNumber) {
                $q->where('title', 'like', '%'.$keyword.'%')
                    ->orWhere('description', 'like', '%'.$keyword.'%');

                if ($monthNameNumber !== null) {
                    $q->orWhereMonth('date_available', $monthNameNumber);
                }

                if (is_numeric($keyword)) {
                    $num = (float) $keyword;

                    // Match price column
                    $q->orWhere('price', $num);

                    // Match Year (e.g. 2026)
                    if ($num >= 1000 && $num <= 9999) {
                        $q->orWhereYear('date_available', (int) $num);
                    }

                    // Match Day (1-31)
                    if ($num >= 1 && $num <= 31) {
                        $q->orWhereDay('date_available', (int) $num);
                    }

                    // Match Month (1-12)
                    if ($num >= 1 && $num <= 12) {
                        $q->orWhereMonth('date_available', (int) $num);
                    }
                }
            });
        }

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
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
        $allowedSorts = ['title', 'price', 'date_available', 'created_at'];
        $orderBy = in_array($orderBy, $allowedSorts, true) ? $orderBy : 'created_at';
        $orderDir = in_array(strtolower($orderDir), ['asc', 'desc'], true) ? strtolower($orderDir) : 'desc';

        $query = Product::query();

        if ($search !== null && trim($search) !== '') {
            $monthNameNumber = $this->resolveMonthName($search);
            $query->where(function ($q) use ($search, $monthNameNumber) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');

                if ($monthNameNumber !== null) {
                    $q->orWhereMonth('date_available', $monthNameNumber);
                }

                if (is_numeric($search)) {
                    $num = (float) $search;

                    // Match price column
                    $q->orWhere('price', $num);

                    // Match Year (e.g. 2026)
                    if ($num >= 1000 && $num <= 9999) {
                        $q->orWhereYear('date_available', (int) $num);
                    }

                    // Match Day (1-31)
                    if ($num >= 1 && $num <= 31) {
                        $q->orWhereDay('date_available', (int) $num);
                    }

                    // Match Month (1-12)
                    if ($num >= 1 && $num <= 12) {
                        $q->orWhereMonth('date_available', (int) $num);
                    }
                }
            });
        }

        $totalRecords = Product::count();
        $filteredRecords = $query->count();

        $data = $query->orderBy($orderBy, $orderDir)
            ->offset($start)
            ->limit($length)
            ->get();

        return [
            'total' => $totalRecords,
            'filtered' => $filteredRecords,
            'data' => $data,
        ];
    }

    /**
     * Find a product by ID.
     */
    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Create a new product.
     */
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    /**
     * Update an existing product.
     */
    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product;
    }

    /**
     * Delete a product.
     */
    public function delete(Product $product): bool
    {
        return (bool) $product->delete();
    }

    /**
     * Resolve month number from a month name search string.
     */
    protected function resolveMonthName(?string $search): ?int
    {
        if ($search === null) {
            return null;
        }

        $normalizedSearch = strtolower(trim($search));

        $monthsMap = [
            'january' => 1, 'jan' => 1,
            'february' => 2, 'feb' => 2,
            'march' => 3, 'mar' => 3,
            'april' => 4, 'apr' => 4,
            'may' => 5,
            'june' => 6, 'jun' => 6,
            'july' => 7, 'jul' => 7,
            'august' => 8, 'aug' => 8,
            'september' => 9, 'sep' => 9, 'sept' => 9,
            'october' => 10, 'oct' => 10,
            'november' => 11, 'nov' => 11,
            'december' => 12, 'dec' => 12,
        ];

        return $monthsMap[$normalizedSearch] ?? null;
    }
}
