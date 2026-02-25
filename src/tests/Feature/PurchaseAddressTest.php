<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\ConditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseAddressTest extends TestCase
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

    public function test_送付先住所の変更反映()
    {
        $user = User::factory()->create(['is_profile_set' => true]);
        Address::factory()->create([
            'user_id' => $user->id,
            'is_profile' => true,
            'address' => 'プロフィールに結びついた住所',
        ]);

        $seller = User::factory()->create(['is_profile_set' => true]);
        $product = Product::factory()->create(['user_id' => $seller->id]);

        $response = $this->actingAs($user)->post(route('address.update', ['product' => $product]), [
            'post_code' => '123-4567',
            'address' => '送付先変更住所',
        ]);

        $response->assertStatus(302);
        $newAddress = Address::where('address', '送付先変更住所')->first();

        $response = $this->actingAs($user)->get(route('purchase.show', [
            'product' => $product->id,
            'selected_address_id' => $newAddress->id,
        ]));

        $response->assertSee('送付先変更住所');
        $response->assertDontSee('プロフィールに結びついた住所');
    }
}
