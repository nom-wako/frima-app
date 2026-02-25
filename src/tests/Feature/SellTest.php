<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ConditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ConditionSeeder::class);
        $this->seed(CategorySeeder::class);
    }

    public function test_商品の出品完了()
    {
        $user = User::factory()->create(['is_profile_set' => true]);
        $category = Category::first();
        $condition = Condition::first();

        Storage::fake('public');
        $image = UploadedFile::fake()->create('product.jpeg', 100);

        $response = $this->actingAs($user)->post(route('product.store'), [
            'name' => 'テスト商品',
            'description' => '商品説明文です。',
            'price' => 12000,
            'condition_id' => (string)$condition->id,
            'brand' => 'テストブランド',
            'categories' => [$category->id],
            'img_url' => $image,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'price' => 12000,
            'condition_id' => 1,
            'brand' => 'テストブランド',
            'is_sold' => 0,
        ]);

        $product = Product::where('name', 'テスト商品')->first();

        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => $category->id,
        ]);
    }
}
