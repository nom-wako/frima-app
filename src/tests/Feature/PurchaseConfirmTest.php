<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\ConditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseConfirmTest extends TestCase
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

    public function test_支払方法選択の反映()
    {
        $user = User::factory()->create(['is_profile_set' => true]);
        Address::factory()->create(['user_id' => $user->id, 'is_profile' => true]);

        $seller = User::factory()->create(['is_profile_set' => true]);
        $product = Product::factory()->create(['user_id' => $seller->id]);

        $response = $this->actingAs($user)->get(route('purchase.show', [
            'product' => $product,
            'payment_method' => '2',
        ]));

        $response->assertStatus(200);
        $response->assertSee('カード払い');
    }
}
