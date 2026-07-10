<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test validation rules for product creation.
     */
    public function test_product_validation_rules(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // 1. Test empty fields
        $response = $this->actingAs($admin)->post(route('products.store'), [
            'title' => '',
            'description' => '',
            'price' => '',
            'date_available' => '',
        ]);

        $response->assertSessionHasErrors([
            'title' => 'The product title is required.',
            'description' => 'The product description cannot be empty.',
            'price' => 'Please specify a price for the product.',
            'date_available' => 'Please select the date when the product becomes available.',
        ]);

        // 2. Test invalid types (string price, invalid date, title length limit)
        $response = $this->actingAs($admin)->post(route('products.store'), [
            'title' => str_repeat('a', 256),
            'description' => 'Fine description',
            'price' => 'not-a-number',
            'date_available' => 'invalid-date-format',
        ]);

        $response->assertSessionHasErrors([
            'title' => 'The product title may not be greater than 255 characters.',
            'price' => 'The product price must be a valid number.',
            'date_available' => 'The availability date must be a valid date.',
        ]);

        // 3. Test negative price
        $response = $this->actingAs($admin)->post(route('products.store'), [
            'title' => 'Valid Title',
            'description' => 'Fine description',
            'price' => -5.00,
            'date_available' => '2026-09-09',
        ]);

        $response->assertSessionHasErrors([
            'price' => 'The product price must be at least 0.00.',
        ]);
    }
}
