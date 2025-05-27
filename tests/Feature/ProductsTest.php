<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_page_loads_successfully(): void
    {
        $response = $this->get('/catalog');
        $response->assertStatus(200);
    }

    public function test_single_product_page_loads_successfully(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id
        ]);

        $response = $this->get("/product/{$product->id}");
        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_product_creation(): void
    {
        $response = $this->get('/admin/products/create');
        $response->assertRedirect('/login');
    }

    public function test_user_can_add_product_to_favorites(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id
        ]);

        $response = $this->post('/favorites/' . $product->id);
        
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);
    }
} 