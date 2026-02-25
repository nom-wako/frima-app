<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\ConditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
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

    public function test_商品の購入()
    {
        $user = User::factory()->create(['is_profile_set' => true]);
        $address = Address::factory()->create(['user_id' => $user->id]);

        $seller = User::factory()->create(['is_profile_set' => true]);
        $product = Product::factory()->create([
            'user_id' => $seller->id,
            'price' => 1000,
        ]);

        $response = $this->actingAs($user)->post(route('purchase.store', $product), [
            'payment_method' => '1',
            'address_id' => $address->id,
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'address_id' => $address->id,
        ]);

        $response->assertStatus(302);
    }

    public function test_購入済商品のSold表示()
    {
        $user = User::factory()->create(['is_profile_set' => true]);
        $address = Address::factory()->create(['user_id' => $user->id]);

        $seller = User::factory()->create(['is_profile_set' => true]);
        $product = Product::factory()->create([
            'user_id' => $seller->id,
            'price' => 1000,
        ]);

        $response = $this->actingAs($user)->post(route('purchase.store', $product), [
            'payment_method' => '1',
            'address_id' => $address->id,
        ]);

        $response = $this->get(route('products.index'));

        $response->assertSee('Sold');
    }

    public function test_購入商品のプロフィール画面表示()
    {
        $user = User::factory()->create(['is_profile_set' => true]);
        $address = Address::factory()->create(['user_id' => $user->id]);

        $seller = User::factory()->create(['is_profile_set' => true]);
        $product = Product::factory()->create([
            'name' => '高級なペン',
            'user_id' => $seller->id,
            'price' => 1000,
        ]);

        $response = $this->actingAs($user)->post(route('purchase.store', $product), [
            'payment_method' => '1',
            'address_id' => $address->id,
        ]);

        $response = $this->actingAs($user)->get(route('profile.show', ['page' => 'buy']));

        $response->assertSee('高級なペン');
    }
}
