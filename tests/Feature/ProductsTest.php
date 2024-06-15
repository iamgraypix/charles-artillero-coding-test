<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_products()
    {
        $products = Product::factory(10)->create();
        
        $response = $this->getJson('api/products');

        $response->assertStatus(200)->assertJsonCount(10, 'data');
    }

    public function test_find_product()
    {
        $product = Product::factory()->create();

        $data = [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price
        ];

        $response = $this->getJson("api/products/{$product->id}");

        $response->assertStatus(200)->assertJson($data);

    }

    public function test_add_product()
    {
        $data = [
            'name' => 'Test name',
            'description' => 'Test description',
            'price' => 2.6
        ];

        $response = $this->postJson('api/products', $data);

        $response->assertStatus(201)->assertJson($data);
    }

    public function test_update_product()
    {
        $product = Product::factory()->create();

        $updateData = [
            'name' => 'updated name',
            'description' => 'updated description',
            'price' => 2.0
        ];

        $response = $this->putJson("api/products/{$product->id}", $updateData);

        $response->assertStatus(200)->assertJson($updateData);
    }

    public function test_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("api/products/{$product->id}");

        $response->assertStatus(200);
    }
}
