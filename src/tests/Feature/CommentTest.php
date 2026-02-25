<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\ConditionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
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

    public function test_コメント送信()
    {
        $user = User::factory()->create(['is_profile_set' => true]);
        $product = Product::factory()->create();
        $commentData = ['comment' => 'これはテストコメントです。'];

        $response = $this->actingAs($user)->post(route('comment.store', $product), $commentData);;

        $this->assertDatabaseHas('comments', [
            'product_id' => $product->id,
            'user_id' => $user->id,
            'comment' => 'これはテストコメントです。',
        ]);

        $response->assertStatus(302);
        $this->get(route('products.show', $product))->assertSee('これはテストコメントです。');
    }

    public function test_ログイン前コメント不可()
    {
        $product = Product::factory()->create();
        $commentData = ['comment' => 'ログインしていません'];

        $response = $this->post(route('comment.store', $product), $commentData);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('comments', $commentData);
    }

    public function test_コメントの必須バリデーション()
    {
        $user = User::factory()->create(['is_profile_set' => true]);
        $product = Product::factory()->create();
        $commentData = ['comment' => ''];

        $response = $this->actingAs($user)->from(route('products.show', $product))->post(route('comment.store', $product), $commentData);;

        $response->assertSessionHasErrors(['comment']);
        $this->assertDatabaseMissing('comments', ['user_id' => $user->id]);
    }

    public function test_コメントの文字数超過バリデーション()
    {
        $user = User::factory()->create(['is_profile_set' => true]);
        $product = Product::factory()->create();
        $commentData = ['comment' => str_repeat('あ', 256)];

        $response = $this->actingAs($user)->from(route('products.show', $product))->post(route('comment.store', $product), $commentData);;

        $response->assertSessionHasErrors(['comment']);
    }
}
