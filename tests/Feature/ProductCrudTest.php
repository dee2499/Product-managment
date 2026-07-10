<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test catalog is inaccessible to guests.
     */
    public function test_guests_cannot_view_catalog(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test catalog HTML page can be viewed by authenticated users.
     */
    public function test_authenticated_users_can_view_catalog_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee('Catalog Items');
    }

    /**
     * Test catalog data can be fetched via AJAX.
     */
    public function test_authenticated_users_can_fetch_catalog_via_ajax(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['title' => 'Awesome AJAX Product']);

        $response = $this->actingAs($user)->getJson(route('products.index', ['draw' => 1]));

        $response->assertStatus(200);
        $response->assertJsonStructure(['draw', 'recordsTotal', 'recordsFiltered', 'data']);
        $this->assertStringContainsString('Awesome AJAX Product', $response->json('data.0.title'));
    }

    /**
     * Test search filters by title and description via AJAX.
     */
    public function test_users_can_search_products_via_ajax(): void
    {
        $user = User::factory()->create();
        Product::factory()->create(['title' => 'Searchable Product Name', 'description' => 'Unrelated text', 'date_available' => '2026-05-10']);
        Product::factory()->create(['title' => 'Unrelated Title', 'description' => 'Detailed searching string keyword', 'date_available' => '2026-06-15']);
        Product::factory()->create(['title' => 'Ignored Product', 'description' => 'No matching text', 'date_available' => '2026-08-20']);

        // July Product
        Product::factory()->create(['title' => 'July Product Title', 'description' => 'No match', 'date_available' => '2026-07-22']);

        // Search by title
        $response1 = $this->actingAs($user)->getJson(route('products.index', [
            'draw' => 1,
            'search' => ['value' => 'Name'],
        ]));
        $response1->assertStatus(200);
        $this->assertStringContainsString('Searchable Product Name', $response1->json('data.0.title'));

        // Search by description
        $response2 = $this->actingAs($user)->getJson(route('products.index', [
            'draw' => 2,
            'search' => ['value' => 'searching'],
        ]));
        $response2->assertStatus(200);
        $this->assertStringContainsString('Unrelated Title', $response2->json('data.0.title'));

        // Search by Month Name (July)
        $response3 = $this->actingAs($user)->getJson(route('products.index', [
            'draw' => 3,
            'search' => ['value' => 'July'],
        ]));
        $response3->assertStatus(200);
        $this->assertStringContainsString('July Product Title', $response3->json('data.0.title'));
        $this->assertCount(1, $response3->json('data'));

        // Search by Month Number (07)
        $response4 = $this->actingAs($user)->getJson(route('products.index', [
            'draw' => 4,
            'search' => ['value' => '07'],
        ]));
        $response4->assertStatus(200);
        $this->assertStringContainsString('July Product Title', $response4->json('data.0.title'));
        $this->assertCount(1, $response4->json('data'));

        // Search by Day Number (22)
        $response5 = $this->actingAs($user)->getJson(route('products.index', [
            'draw' => 5,
            'search' => ['value' => '22'],
        ]));
        $response5->assertStatus(200);
        $this->assertStringContainsString('July Product Title', $response5->json('data.0.title'));
        $this->assertCount(1, $response5->json('data'));

        // Search by Year Number (2026)
        $response6 = $this->actingAs($user)->getJson(route('products.index', [
            'draw' => 6,
            'search' => ['value' => '2026'],
        ]));
        $response6->assertStatus(200);
        $this->assertCount(4, $response6->json('data')); // All four seeded products have year 2026

        // Add a product with unique price
        Product::factory()->create(['title' => 'Priced Product', 'price' => 99.95, 'date_available' => '2026-09-09']);

        // Search by Price (99.95)
        $response7 = $this->actingAs($user)->getJson(route('products.index', [
            'draw' => 7,
            'search' => ['value' => '99.95'],
        ]));
        $response7->assertStatus(200);
        $this->assertStringContainsString('Priced Product', $response7->json('data.0.title'));
        $this->assertCount(1, $response7->json('data'));
    }

    /**
     * Test role-based authorization for writing operations.
     */
    public function test_standard_users_cannot_perform_write_actions(): void
    {
        $user = User::factory()->create(['role' => 'standard']);
        $product = Product::factory()->create();

        // Try viewing create page
        $this->actingAs($user)->get(route('products.create'))->assertStatus(403);

        // Try storing product
        $this->actingAs($user)->post(route('products.store'), [
            'title' => 'New Product',
            'description' => 'Desc',
            'price' => 10.00,
            'date_available' => now()->format('Y-m-d'),
        ])->assertStatus(403);

        // Try viewing edit page
        $this->actingAs($user)->get(route('products.edit', $product))->assertStatus(403);

        // Try updating product
        $this->actingAs($user)->put(route('products.update', $product), [
            'title' => 'Updated Title',
            'description' => 'Desc',
            'price' => 10.00,
            'date_available' => now()->format('Y-m-d'),
        ])->assertStatus(403);

        // Try deleting product
        $this->actingAs($user)->delete(route('products.destroy', $product))->assertStatus(403);
    }

    /**
     * Test admin can perform all CRUD actions.
     */
    public function test_admin_users_can_perform_all_crud_actions(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create(['title' => 'Original Product']);

        // View create page
        $this->actingAs($admin)->get(route('products.create'))->assertStatus(200);

        // Store new product
        $response = $this->actingAs($admin)->post(route('products.store'), [
            'title' => 'Fresh Product',
            'description' => '<p>Sanitized script test <script>alert("XSS")</script></p>',
            'price' => 25.50,
            'date_available' => '2026-10-10',
        ]);
        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'title' => 'Fresh Product',
            'description' => '<p>Sanitized script test </p>', // Verify XSS sanitization
            'price' => '25.50',
            'date_available' => '2026-10-10 00:00:00',
        ]);

        // View edit page
        $this->actingAs($admin)->get(route('products.edit', $product))->assertStatus(200);

        // Update product
        $response = $this->actingAs($admin)->put(route('products.update', $product), [
            'title' => 'Updated Product Title',
            'description' => 'New Description',
            'price' => 100.00,
            'date_available' => '2026-12-25',
        ]);
        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'title' => 'Updated Product Title',
            'description' => 'New Description',
            'price' => '100.00',
            'date_available' => '2026-12-25 00:00:00',
        ]);

        // Delete product
        $response = $this->actingAs($admin)->delete(route('products.destroy', $product));
        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
