<?php

namespace Tests\Feature\Api\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Tests\TestCase;

class ProductStoreTest extends TestCase
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

    public function product_can_be_stored(): void
    {
        $this->withExceptionHandling();
    
        $product = Product::factory()->make()->toArray();
            
        $response = $this->post("/api/V1/products", $product);

        $response->assertOk();

        $response->assertJson([
            "name" => $product["name"],
            "description" => $product["description"],
            "price" => $product["price"],
            "image_url" => $product["image_url"]
        ]);

        $this->assertDatabaseCount("products", 1);

        $productCreated = Product::query()->first();

        $this->assertEquals($product["name"], $productCreated->name);
        $this->assertEquals($product["description"], $productCreated->description);
        $this->assertEquals($product["price"], $productCreated->price);
        $this->assertEquals($product["image_url"], $productCreated->image_url);
    }

    // 'name' => ['required', 'string', 'max:50', 'min:2'],
    // 'description' => ['required', 'string', 'max:200', 'min:3'],
    // 'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
    // 'image_url' => ['nullable', 'url'],

    /** @test */

    public function attr_name_is_required_for_store_product(): void
    {
        $product = Product::factory()->make(["name" => null])->toArray();
        
        $response = $this->post("/api/V1/products", $product);

        $response->assertStatus(422);
        $response->assertInvalid("name");
    }

    public function attr_description_is_required_for_store_product(): void
    {
        $product = Product::factory()->make(["description" => null])->toArray();
        
        $response = $this->post("/api/V1/products", $product);

        $response->assertStatus(422);
        $response->assertInvalid("description");
    }

    /** @test */

    public function attr_price_is_required_for_store_product(): void
    {
        $product = Product::factory()->make(["price" => null])->toArray();
        
        $response = $this->post("/api/V1/products", $product);

        $response->assertStatus(422);
        $response->assertInvalid("price");
    }

    /** @test */
    public function it_validates_string_for_name_field(): void
    {
        $product = Product::factory()->make(['name' => 123])->toArray();

        $response = $this->post('/api/V1/products', $product);

        $response->assertStatus(422);
        $response->assertInvalid("name");
    }

    /** @test */

    public function it_validates_string_for_description_field(): void
    {
        $product = Product::factory()->make(['description' => 123])->toArray();
    
        $response = $this->post('/api/V1/products', $product);
    
        $response->assertStatus(422);
        $response->assertInvalid("description");
    }

    /** @test */

    public function it_validates_string_for_image_url_field(): void
    {
        $product = Product::factory()->make(['image_url' => 123])->toArray();
    
        $response = $this->post('/api/V1/products', $product);
    
        $response->assertStatus(422);
        $response->assertInvalid("image_url");
    }

    /** @test */

    public function name_attr_should_not_have_more_than_50_characters(): void
    {
        $product = Product::factory()->make(['name' => str_repeat('n', 51)])->toArray();

        $response = $this->post("/api/V1/products", $product);

        $response->assertStatus(422);
        $response->assertInvalid("name");
    }

    /** @test */

    public function name_attr_must_have_more_than_2_characters(): void
    {
        $product = Product::factory()->make(['name' => "n"])->toArray();

        $response = $this->post("/api/V1/products", $product);

        $response->assertStatus(422);
        $response->assertInvalid("name");
    }

    /** @test */

    public function description_attr_should_not_have_more_than_200_characters(): void
    {
        $product = Product::factory()->make(['description' => str_repeat('n', 201)])->toArray();

        $response = $this->post("/api/V1/products", $product);

        $response->assertStatus(422);
        $response->assertInvalid("description");
    }

    /** @test */

    public function description_attr_must_have_more_than_3_characters(): void
    {
        $product = Product::factory()->make(['description' => str_repeat("n", 2)])->toArray();

        $response = $this->post("/api/V1/products", $product);

        $response->assertStatus(422);
        $response->assertInvalid("description");
    }

    /** @test */

    public function price_attribute_should_match_regex_pattern(): void
    {
        $product = Product::factory()->make(['price' => '123.456'])->toArray();


        $response = $this->post('/api/V1/products', $product);

        $response->assertStatus(422);
        $response->assertInvalid("price");
        $response->assertJsonValidationErrors([
            'price' => __('validation.regex', ['attribute' => 'price']),
        ]);
    }

    /** @test */

    public function price_attr_should_be_positive(): void
    {
        $product = Product::factory()->make(["price" => -1])->toArray();

        $response = $this->post("/api/V1/products", $product);

        $response->assertStatus(422);
        $response->assertInvalid("price");
    }

}
