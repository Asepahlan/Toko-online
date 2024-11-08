<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        // Buat admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'phone' => '6285215142110',
                'address' => 'Jl. Admin No. 1'
            ]
        );
        $admin->assignRole('admin');

        // Buat user biasa untuk testing
        $user = User::firstOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'User Test',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'user',
                'phone' => '6285215142110',
                'address' => 'Jl. User No. 1'
            ]
        );
        $user->assignRole('user');

        // Buat kategori
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Produk elektronik', 'slug' => 'elektronik'],
            ['name' => 'Pakaian', 'description' => 'Produk pakaian', 'slug' => 'pakaian'],
            ['name' => 'Makanan', 'description' => 'Produk makanan', 'slug' => 'makanan'],
            ['name' => 'Minuman', 'description' => 'Produk minuman', 'slug' => 'minuman'],
            ['name' => 'Aksesoris', 'description' => 'Produk aksesoris', 'slug' => 'aksesoris'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        // Buat beberapa produk contoh untuk setiap kategori
        $categories = Category::all();
        foreach ($categories as $category) {
            for ($i = 1; $i <= 5; $i++) {
                $name = "Produk {$category->name} $i";
                Product::firstOrCreate(
                    [
                        'name' => $name,
                        'category_id' => $category->id
                    ],
                    [
                        'slug' => Str::slug($name),
                        'description' => "Deskripsi untuk produk {$category->name} $i",
                        'price' => rand(10000, 1000000),
                        'stock' => rand(10, 100),
                        'image_url' => 'https://via.placeholder.com/400x300',
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
