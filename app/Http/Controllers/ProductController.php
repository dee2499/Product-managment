<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * ProductController constructor.
     */
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        Gate::authorize('viewAny', Product::class);

        if ($request->ajax() || $request->wantsJson()) {
            $draw = $request->integer('draw');
            $start = $request->integer('start', 0);
            $length = $request->integer('length', 10);

            $search = $request->input('search.value');

            $orderColumnIndex = $request->integer('order.0.column', 0);
            $orderDir = $request->input('order.0.dir', 'desc');

            $columns = [
                0 => 'title',
                1 => 'created_at', // Description column
                2 => 'price',
                3 => 'date_available',
            ];
            $sortBy = $columns[$orderColumnIndex] ?? 'created_at';

            $result = $this->productService->getForDataTable($search, $sortBy, $orderDir, $start, $length);

            $formattedData = [];
            foreach ($result['data'] as $product) {
                // Generate action buttons HTML safely
                $showUrl = route('products.show', $product);
                $editUrl = route('products.edit', $product);
                $deleteUrl = route('products.destroy', $product);

                $actions = '<div class="d-flex justify-content-end gap-1.5">';
                $actions .= '<a href="'.$showUrl.'" class="btn btn-light btn-sm"><i class="bi bi-eye-fill"></i></a>';

                if ($request->user() !== null && $request->user()->can('update', $product)) {
                    $actions .= '<a href="'.$editUrl.'" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-fill"></i></a>';
                }

                if ($request->user() !== null && $request->user()->can('delete', $product)) {
                    $actions .= '<form method="POST" action="'.$deleteUrl.'" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this product?\');">';
                    $actions .= csrf_field();
                    $actions .= method_field('DELETE');
                    $actions .= '<button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash-fill"></i></button>';
                    $actions .= '</form>';
                }
                $actions .= '</div>';

                // Available Date Badge HTML safely
                $dateFormatted = $product->date_available->format('M d, Y');
                if ($product->date_available->isFuture()) {
                    $badge = '<span class="badge bg-warning text-dark px-2.5 py-1.5 rounded">'.$dateFormatted.' (Upcoming)</span>';
                } else {
                    $badge = '<span class="badge bg-success px-2.5 py-1.5 rounded">'.$dateFormatted.' (Available)</span>';
                }

                $formattedData[] = [
                    'title' => '<div class="fw-bold">'.e($product->title).'</div>',
                    'description' => '<div class="text-muted small text-truncate" style="max-width: 18rem;" title="'.e(strip_tags($product->description)).'">'.
                                     e(Str::limit(strip_tags($product->description), 80)).'</div>',
                    'price' => '<span class="fw-bold text-primary">$'.number_format((float) $product->price, 2).'</span>',
                    'date_available' => $badge,
                    'actions' => $actions,
                ];
            }

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $result['total'],
                'recordsFiltered' => $result['filtered'],
                'data' => $formattedData,
            ]);
        }

        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('create', Product::class);

        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        Gate::authorize('create', Product::class);

        $this->productService->create($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        Gate::authorize('view', $product);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        Gate::authorize('update', $product);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        Gate::authorize('update', $product);

        $this->productService->update($product, $request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        Gate::authorize('delete', $product);

        $this->productService->delete($product);

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
