<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\ConditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
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

    public function test_いいね登録()
    {
        $user = User::factory()->create([
            'is_profile_set' => true,
        ]);
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post(route('favorite.store', $product));

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->get(route('products.show', ['product' => $product->id]));
        $response->assertSee('1');
    }

    public function test_いいね登録時のアイコン変化()
    {
        $user = User::factory()->create([
            'is_profile_set' => true,
        ]);
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post(route('favorite.store', $product));
        $response = $this->get(route('products.show', ['product' => $product->id]));

        $response->assertSee('is-active');
    }

    public function test_いいね解除()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $user->favoriteProducts()->attach($product->id);

        $response = $this->actingAs($user)->post(route('favorite.destroy', ['product_id', $product->id]));

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'prodduct_id' => $product->id,
        ]);

        $response = $this->get(route('products.show', ['product' => $product->id]));
        $response->assertSee('0');
    }
}
