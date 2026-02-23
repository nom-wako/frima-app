<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // プロフィール設定画面の表示
    public function edit()
    {
        // ログインしているユーザー情報を取得
        $user = Auth::user();
        $address = $user->profileAddress;
        return view('mypage.profile', compact('user', 'address'));
    }

    // プロフィールの登録・更新
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            // 画像保存処理
            $imgUrl = $user->img_url;
            if ($request->hasFile('img_url')) {
                // 既存の画像は削除
                if ($user->img_url) {
                    Storage::disk('public')->delete($user->img_url);
                }
                // 新しい画像の保存
                $imgUrl = $request->file('img_url')->store('profiles', 'public');
            }

            // Usersテーブルの更新
            $user->update([
                'name' => $request->name,
                'img_url' => $imgUrl,
                'is_profile_set' => true,
            ]);

            // プロフィール用の住所の更新・作成
            $user->profileAddress()->updateOrCreate(
                [
                    'is_profile' => true,
                ],
                [
                    'post_code' => $request->post_code,
                    'address' => $request->address,
                    'building' => $request->building,
                ]
            );
        });

        return redirect('/mypage/profile')->with('status', 'プロフィールを更新しました');
    }
}
