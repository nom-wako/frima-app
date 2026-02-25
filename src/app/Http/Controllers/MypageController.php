<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MypageController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        if ($page === 'buy') {
            $products = $user->purchasedProducts()->with('product')->get();
        } else {
            $products = $user->products;
        }
        return view('mypage.mypage', compact('user', 'products', 'page'));
    }

    public function edit()
    {
        $user = Auth::user();
        $address = $user->profileAddress;
        return view('mypage.profile', compact('user', 'address'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($request, $user) {
            $imgUrl = $user->img_url;
            if ($request->hasFile('img_url')) {
                if ($user->img_url) {
                    Storage::disk('public')->delete($user->img_url);
                }
                $imgUrl = $request->file('img_url')->store('profiles', 'public');
            }

            $user->update([
                'name' => $request->name,
                'img_url' => $imgUrl,
                'is_profile_set' => true,
            ]);

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
