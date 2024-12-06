<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('home', [
        'title' => 'Home'
    ]);
});
Route::get('/about', function () {
    return view('about', [
        'title' => 'About'
    ]);
});
Route::get('/posts', function () {
    // untuk memanggil semua post
    // $posts = Post::all();
    // untuk memanggil semua post dengan fungsi get
    // gunakan with ([author, category]) jika ingin menghindari lazy loading
    // $posts = Post::latest()->get();

    // simple searching
    // if (request('search')) {
    //     $posts->where('title', 'like', '%' . request('search') . '%');
    // };

    // $posts = Post::latest();
    return view('posts', [
        'title' => 'Blog',
        // versi tanpa searching
        // 'posts' => $posts->get()
        // versi dengan fitur searching
        'posts' => Post::filter(request(['search', 'category', 'author']))->latest()->paginate(2)->withQueryString()
    ]);
});

Route::get('/posts/{post:slug}', function (Post $post) {
    // $post = Post::find($slug);

    return view('post', [
        'title' => 'Single Post',
        'post' => $post
    ]);
});

Route::get('/author/{user:username}', function (User $user) {
    // jika ingin menggunakan eager loading
    // $posts = $user->posts->load('category', 'author'); 
    return view('posts', [
        'title' => '(' . count($user->posts) . ') Articles by: ' . $user->name,
        'posts' => $user->posts
    ]);
});

Route::get('/categories/{category:slug}', function (Category $category) {
    // jika ingin menggunakan eager loading
    // $posts = $category->posts->load('category', 'author');
    return view('posts', [
        'title' => count($category->posts) . ' Article di Category ' .  $category->name,
        'posts' => $category->posts
    ]);
});

Route::get('/contact', function () {
    return view('contact', [
        'title' => 'Contact'
    ]);
});
