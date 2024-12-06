<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        // jika ingin menambahkan data manual : 
        // $admin = User::create([
        //     'name' => 'Ren Amamiya',
        //     'username' => 'Ren',
        //     'email' => '1HbBt@example.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('password'),
        //     'remember_token' => Str::random(10),
        // ]);
        // $extra_category = Category::create([
        //     'name' => 'Kontolz',
        //     'slug' => 'slug-kntl',

        // ]);

        // versi dengan 1 seeder:
        // Post::factory(10)->recycle([
        //     $extra_category,
        //     Category::factory(3)->create(),
        //     $admin,
        //     User::factory(3)->create()
        // ])->create();

        // versi jika seeder berbeda file :
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
        ]);
        Post::factory(10)->recycle([
            User::all(),
            Category::all()
        ])->create();
    }
}
