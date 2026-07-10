<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_redirects_unauthenticated_to_products(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('products.index'));
    }
}
