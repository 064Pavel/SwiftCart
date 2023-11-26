<?php

namespace Tests\Feature\Api\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Tests\TestCase;

class ProductUpdateTest extends TestCase
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

    public function products_can_be_updated(): void
    {
        $this->withExceptionHandling();
    
        $product = Product::factory()->create();

        $productUpd = [
            "name" => "updated name",
            "description" => "updated description",
            "price" => 1999.99,
            "image_url" => null,
        ];

        $response = $this->patch("/api/V1/products/" . $product->id, $productUpd);

        $response->assertOk();

        $response->assertJson([
            "name" => $productUpd["name"],
            "description" => $productUpd["description"],
            "price" => $productUpd["price"],
            "image_url" => $productUpd["image_url"],
        ]);

        $productData = Product::query()->first();

        $this->assertEquals($product->id, $productData["id"]);
        $this->assertEquals($productUpd["name"], $productData["name"]);
        $this->assertEquals($productUpd["description"], $productData["description"]);
        $this->assertEquals($productUpd["price"], $productData["price"]);
        $this->assertEquals($productUpd["image_url"], $productData["image_url"]);
    
    }

    // 'name' => ['required', 'string', 'max:50', 'min:2'],
    // 'description' => ['required', 'string', 'max:200', 'min:3'],
    // 'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
    // 'image_url' => ['nullable', 'url'],

    /** @test */

    public function attr_name_is_required_for_update_product(): void
    {
        $product = Product::factory()->create();
        
        $response = $this->patch("/api/V1/products/" . $product->id, ["name" => null]);

        $response->assertStatus(422);
        $response->assertInvalid("name");
    }

    public function attr_description_is_required_for_update_product(): void
    {
        $product = Product::factory()->create();
        
        $response = $this->patch("/api/V1/products/" . $product->id, ["description" => null]);

        $response->assertStatus(422);
        $response->assertInvalid("description");
    }

    /** @test */

    public function attr_price_is_required_for_update_product(): void
    {
        $product = Product::factory()->create();
        
        $response = $this->patch("/api/V1/products/" . $product->id, ["price" => null]);

        $response->assertStatus(422);
        $response->assertInvalid("price");
    }

    /** @test */
    public function it_validates_string_for_name_field(): void
    {
        $product = Product::factory()->create();

        $response = $this->patch("/api/V1/products/" . $product->id, ['name' => 123]);

        $response->assertStatus(422);
        $response->assertInvalid("name");
    }

    /** @test */

    public function it_validates_string_for_description_field(): void
    {
        $product = Product::factory()->create();
    
        $response = $this->patch("/api/V1/products/" . $product->id, ['description' => 123]);
    
        $response->assertStatus(422);
        $response->assertInvalid("description");
    }

    /** @test */

    public function it_validates_string_for_image_url_field(): void
    {
        $product = Product::factory()->create();
    
        $response = $this->patch("/api/V1/products/" . $product->id, ['image_url' => 123]);
    
        $response->assertStatus(422);
        $response->assertInvalid("image_url");
    }

    /** @test */

    public function name_attr_should_not_have_more_than_50_characters(): void
    {
        $product = Product::factory()->create();

        $response = $this->patch("/api/V1/products/" . $product->id, ['name' => str_repeat('n', 51)]);

        $response->assertStatus(422);
        $response->assertInvalid("name");
    }

    /** @test */

    public function name_attr_must_have_more_than_2_characters(): void
    {
        $product = Product::factory()->create();

        $response = $this->patch("/api/V1/products/" . $product->id, ['name' => "n"]);

        $response->assertStatus(422);
        $response->assertInvalid("name");
    }

    /** @test */

    public function description_attr_should_not_have_more_than_200_characters(): void
    {
        $product = Product::factory()->create();

        $response = $this->patch("/api/V1/products/" . $product->id, ['description' => str_repeat('n', 201)]);

        $response->assertStatus(422);
        $response->assertInvalid("description");
    }

    /** @test */

    public function description_attr_must_have_more_than_3_characters(): void
    {
        $product = Product::factory()->create();

        $response = $this->patch("/api/V1/products/" . $product->id, ['description' => str_repeat("n", 2)]);

        $response->assertStatus(422);
        $response->assertInvalid("description");
    }

    /** @test */

    public function price_attribute_should_match_regex_pattern(): void
    {
        $product = Product::factory()->create();


        $response = $this->patch("/api/V1/products/" . $product->id, ['price' => '123.456']);

        $response->assertStatus(422);
        $response->assertInvalid("price");
        $response->assertJsonValidationErrors([
            'price' => __('validation.regex', ['attribute' => 'price']),
        ]);
    }

    /** @test */

    public function price_attr_should_be_positive(): void
    {
        $product = Product::factory()->create();

        $response = $this->patch("/api/V1/products/" . $product->id, ["price" => -1]);

        $response->assertStatus(422);
        $response->assertInvalid("price");
    }    

}
