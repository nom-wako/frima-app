<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_プロフィール編集画面の初期値表示()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'img_url' => 'test_profile_image.jpg',
            'is_profile_set' => true,
        ]);

        $profileAddress = Address::factory()->create([
            'user_id' => $user->id,
            'post_code' => '111-1111',
            'address' => '初期値の住所',
            'building' => '初期値の建物',
            'is_profile' => true,
        ]);

        Address::factory()->create([
            'user_id' => $user->id,
            'post_code' => '999-9999',
            'address' => '別の住所',
            'is_profile' => false,
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('test_profile_image.jpg');
        $response->assertSee('111-1111');
        $response->assertSee('初期値の住所');
        $response->assertSee('初期値の建物');

        $response->assertDontSee('999-9999');
        $response->assertDontSee('別の住所');
    }
}
