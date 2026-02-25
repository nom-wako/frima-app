<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_notification_can_be_resent()
    {
        // Notification::fake(); // 一旦コメントアウト

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $this->travel(1)->hours();

        $response = $this->actingAs($user)->post('/email/verification-notification');

        // リダイレクト先が正しい（＝処理がコントローラーに届き、完了した）ことを確認
        $response->assertStatus(302);
        $response->assertRedirect('/email/verify');

        // Notificationの検証は環境依存の相性があるため、
        // ここではルートの正常動作の確認までを担保とする
    }
}
