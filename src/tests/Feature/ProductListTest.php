<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\ConditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductListTest extends TestCase
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
    }

    public function test_すべての商品が表示される()
    {
        Product::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $products = Product::all();
        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    public function test_購入済商品のSold表示()
    {
        $soldProduct = Product::factory()->create([
            'name' => '売却済の皿',
            'is_sold' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    public function test_出品商品の一覧非表示()
    {
        $user = User::factory()->create();

        Product::factory()->create([
            'user_id' => $user->id,
            'name' => '私の出品したバッグ'
        ]);

        Product::factory()->create([
            'name' => '他人の出品した時計'
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('他人の出品した時計');
        $response->assertDontSee('私の出品したバッグ');
    }
}
