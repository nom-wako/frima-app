<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_名前の必須バリデーション()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertSessionHasErrors(['name']);

        $response = $this->get('/register');
        $response->assertSee('お名前を入力してください');
    }

    public function test_メールアドレスの必須バリデーション()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertSessionHasErrors(['email']);

        $response = $this->get('/register');
        $response->assertSee('メールアドレスを入力してください');
    }

    public function test_パスワードの必須バリデーション()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => 'password123'
        ]);

        $response->assertSessionHasErrors(['password']);

        $response = $this->get('/register');
        $response->assertSee('パスワードを入力してください');
    }

    public function test_パスワードの7文字以下バリデーション()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'passwor',
            'password_confirmation' => 'passwor'
        ]);

        $response->assertSessionHasErrors(['password']);

        $response = $this->get('/register');
        $response->assertSee('パスワードは8文字以上で入力してください');
    }

    public function test_パスワードの不一致バリデーション()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different_password'
        ]);

        $response->assertSessionHasErrors(['password']);

        $response = $this->get('/register');
        $response->assertSee('パスワードと一致しません');
    }

    public function test_会員情報登録完了()
    {
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect('/email/verify');
    }
}
