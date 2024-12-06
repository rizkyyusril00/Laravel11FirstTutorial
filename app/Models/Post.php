<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model // direct tabel post
{

    use HasFactory;


    // jika tabel nama table berbeda dengan class, contoh:
    // protected $table = 'blog_posts';

    // default nya nama primary key = id, conoth jika bukan id :
    // protected $primaryKey = 'post_id';

    // agar field dapat diisi, field yang tidak masukan tidak dapat diisi
    protected $fillable = [
        'title',
        'slug',
        'author',
        'content'
    ];

    // unutk eager loading
    protected $with = [
        'author',
        'category'
    ];


    // versi manual 
    // public static function all()
    // {
    //     return [
    //         [
    //             'id' => 1,
    //             'title' => 'Judul Artikel 1',
    //             'slug' => 'judul-artikel-1',
    //             'author' => 'Dwi',
    //             'content' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Commodi, odit.      Impedit adipisci ipsam nam autem! Aliquam placeat ullam laborum in voluptate, sunt molestias optio incidunt error tenetur quos possimus enim.'
    //         ],
    //         [
    //             'id' => 2,
    //             'title' => 'Judul Artikel 2',
    //             'slug' => 'judul-artikel-2',
    //             'author' => 'Ion',
    //             'content' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vitae explicabo consequuntur sed ipsa officiis, quisquam maxime adipisci eius officia ad porro iure dolorum quia rerum esse illum quis dignissimos tempore?'
    //         ]
    //     ];
    // }
    // public static function find($slug): array
    // {

    //     // v1 callback
    //     // return Arr::first(static::all(), function ($post) use ($slug) {
    //     //     return $post['slug'] == $slug;
    //     // });
    //     // v2 arrow function
    //     // return Arr::first(static::all(), fn($post) => $post['slug'] == $slug) ?? abort(404);

    //     $post = Arr::first(static::all(), fn($post) => $post['slug'] == $slug);

    //     if (!$post) {
    //         abort(404);
    //     }

    //     return $post;
    // }

    // unutuk relasi
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // searching code:
    // public function scopeFilter(Builder $query, array $filters): void
    // {
    //     versi if
    //     if (isset($filters['search']) ? $filters['search'] : false) {
    //         $query->where('title', 'like', '%' . request('search') . '%');
    //     }

    // }
    public function scopeFilter(Builder $query, array $filters): void
    {
        // versi when function
        // $query->when(isset($filters['search']) ? $filters['search'] : false, function ($query, $search) {
        //     return $query->where('title', 'like', '%' . request('search') . '%');
        // });
        // versi when arrow function
        $query->when(
            isset($filters['search']) ? $filters['search'] : false,
            fn($query, $search) =>
            $query->where('title', 'like', '%' . $search . '%')
        );

        // versi category
        $query->when(
            isset($filters['category']) ? $filters['category'] : false,
            fn($query, $category) =>
            $query->whereHas('category', fn($query) => $query->where('slug', $category))
        );
        // versi author
        $query->when(
            isset($filters['author']) ? $filters['author'] : false,
            fn($query, $author) =>
            $query->whereHas('author', fn($query) => $query->where('username', $author))
        );
    }
}
