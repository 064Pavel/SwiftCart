<?php

namespace Tests\Feature\Api\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Tests\TestCase;

class ProductDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeaders([
            "accept" => "application/json",
        ]);
    }

        /** @test */

    public function product_can_be_deleted(): void
    {
        $this->withExceptionHandling();
    
        $product = Product::factory()->create();

        $response = $this->delete("/api/V1/products/" . $product->id);

        $response->assertOk();

        $this->assertDatabaseCount("products", 0);
    }

}
