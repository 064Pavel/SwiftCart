<?php

namespace Tests\Feature\Api\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Tests\TestCase;

class ProductIndexTest extends TestCase
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

    public function products_can_be_retrieved(): void
    {
        $this->withExceptionHandling();
    
        $products = Product::factory(10)->create();

        $response = $this->get("/api/V1/products");

        $response->assertOk();
    
        $json = $products->map(function($product){
            return [
                "name" => $product->name,
                "description" => $product->description,
                "price" => $product->price,
                "image_url" => $product->image_url,
            ];
        })->toArray();
    
        $response->assertJson($json);
    
    }

}
