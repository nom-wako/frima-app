<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Database\Seeders\ConditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MypageShowTest extends TestCase
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

    public function test_プロフィール画面の情報表示()
    {
        $user = User::factory()->create([
            'name' => 'テスト太郎',
            'img_url' => 'test_profile_image.jpg',
            'is_profile_set' => true,
        ]);
        $address = Address::factory()->create(['user_id' => $user->id]);

        Product::factory()->count(2)->create([
            'user_id' => $user->id,
            'name' => '出品した商品',
        ]);

        $buyProduct = Product::factory()->create(['name' => '購入した商品']);
        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $buyProduct->id,
            'address_id' => $address->id,
            'payment_method' => '2',
        ]);

        $response = $this->actingAs($user)->get(route('profile.show', ['id' => $user->id]));

        $response->assertStatus(200);
        $response->assertSee('テスト太郎');
        $response->assertSee('test_profile_image.jpg');

        $response->assertSee('出品した商品');

        $response = $this->actingAs($user)->get(route('profile.show', ['page' => 'buy']));
        $response->assertSee('購入した商品');
    }
}
