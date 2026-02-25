<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ConditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDetailTest extends TestCase
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

    public function test_商品詳細情報の表示()
    {
        $product = Product::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 5000,
            'description' => 'これはテスト商品の説明です。',
        ]);

        $categories = Category::take(2)->get();
        $product->categories()->attach($categories->pluck('id'));

        $users = User::factory()->count(2)->create();
        foreach ($users as $u) {
            $u->favoriteProducts()->attach($product->id);
        }

        $commentUser = User::factory()->create(['name' => 'コメントユーザー']);
        Comment::create([
            'user_id' => $commentUser->id,
            'product_id' => $product->id,
            'comment' => '素敵な商品ですね！',
        ]);

        $response = $this->get("/item/{$product->id}");

        $response->assertStatus(200);

        $response->assertSee($product->img_url);
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('5,000');
        $response->assertSee('これはテスト商品の説明です。');

        $response->assertSee('2');
        $response->assertSee('1');

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
        $response->assertSee($product->condition->name);

        $response->assertSee('コメントユーザー');
        $response->assertSee('素敵な商品ですね！');
    }
}
