<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\ConditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyListTest extends TestCase
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

    public function test_いいねした商品のみ表示()
    {
        $user = User::factory()->create();

        $likedProduct = Product::factory()->create(['name' => 'お気に入りの皿']);
        $user->favoriteProducts()->attach($likedProduct->id);

        $unlikedProduct = Product::factory()->create(['name' => '興味のないコップ']);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('お気に入りの皿');
        $response->assertDontSee('興味のないコップ');
    }

    public function test_マイリストでの購入済商品のSold表示()
    {
        $user = User::factory()->create();
        $soldProduct = Product::factory()->create([
            'name' => '売り切れのバッグ',
            'is_sold' => true,
        ]);
        $user->favoriteProducts()->attach($soldProduct->id);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('売り切れのバッグ');
        $response->assertSee('Sold');
    }

    public function test_未認証時のマイリスト表示()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('マイリストの表示にはログインが必要です。');
    }
}
