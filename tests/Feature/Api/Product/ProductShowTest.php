<?php

namespace Tests\Feature\Api\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Tests\TestCase;

class ProductShowTest extends TestCase
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

    public function product_can_be_retrieved(): void
    {
         $this->withExceptionHandling();
            
        $product = Product::factory()->create();

        $response = $this->get("/api/V1/products/" . $product->id);
        // dd($response->getContent());
        $response->assertOk();
            
        $response->assertJson([
            "name" => $product->name,
            "description" => $product->description,
            "price" => $product->price,
            "image_url" => $product->image_url,
        ]);
            
    }

}
