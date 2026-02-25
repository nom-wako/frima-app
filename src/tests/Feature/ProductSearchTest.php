<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\ConditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSearchTest extends TestCase
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

    public function test_商品名の部分一致検索()
    {
        Product::factory()->create(['name' => '和風の皿']);
        Product::factory()->create(['name' => '洋風のコップ']);

        $response = $this->get('/?search=皿');

        $response->assertStatus(200);
        $response->assertSee('和風の皿');
        $response->assertDontSee('洋風のコップ');
    }

    public function test_マイリスト遷移での検索状態保持()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/?search=皿&tab=mylist');

        $response->assertStatus(200);

        $response->assertSeeInOrder(['<input', 'value="皿"'], false);
    }
}
