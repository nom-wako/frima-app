<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::pluck('id')->toArray();

        $products = [
            [
                'condition_id' => 1,
                'name' => '腕時計',
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000,
                'image_path' => 'products/sample01.jpg',
                'is_sold' => false,
            ],
            [
                'condition_id' => 2,
                'name' => 'HDD',
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => 5000,
                'image_path' => 'products/sample02.jpg',
                'is_sold' => false,
            ],
            [
                'condition_id' => 3,
                'name' => '玉ねぎ3束',
                'brand' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => 300,
                'image_path' => 'products/sample03.jpg',
                'is_sold' => false,
            ],
            [
                'condition_id' => 4,
                'name' => '革靴',
                'brand' => '',
                'description' => 'クラシックなデザインの革靴',
                'price' => 4000,
                'image_path' => 'products/sample04.jpg',
                'is_sold' => false,
            ],
            [
                'condition_id' => 1,
                'name' => 'ノートPC',
                'brand' => '',
                'description' => '高性能なノートパソコン',
                'price' => 45000,
                'image_path' => 'products/sample05.jpg',
                'is_sold' => true,
            ],
            [
                'condition_id' => 2,
                'name' => 'マイク',
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'price' => 8000,
                'image_path' => 'products/sample06.jpg',
                'is_sold' => false,
            ],
            [
                'condition_id' => 3,
                'name' => 'ショルダーバッグ',
                'brand' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => 3500,
                'image_path' => 'products/sample07.jpg',
                'is_sold' => false,
            ],
            [
                'condition_id' => 4,
                'name' => 'タンブラー',
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'price' => 500,
                'image_path' => 'products/sample08.jpg',
                'is_sold' => false,
            ],
            [
                'condition_id' => 1,
                'name' => 'コーヒーミル',
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'price' => 4000,
                'image_path' => 'products/sample09.jpg',
                'is_sold' => true,
            ],
            [
                'condition_id' => 2,
                'name' => 'メイクセット',
                'brand' => '',
                'description' => '便利なメイクアップセット',
                'price' => 2500,
                'image_path' => 'products/sample10.jpg',
                'is_sold' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, [
                'user_id' => $users[array_rand($users)],
            ]));
        }
    }
}
