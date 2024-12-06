<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <article class="py-8 max-w-screen-md">
        <h1 class="text-3xl font-bold text-black">{{ $post['title'] }}</h1>
        <div>
            <a href="/posts?author={{ $post->author->username }}"
                class="text-base to-gray-500">{{ $post->author->name }}</a> |
            <a href="/posts?category={{ $post->category->slug }}"
                class="text-base to-gray-500">{{ $post->category->name }}</a> |
            {{ $post->created_at ? $post->created_at->format('d M Y') : 'Untracked' }},
            {{ $post->created_at->diffForHumans() }}
        </div>
        <p class="my-4 font-light">
            {{ $post['content'] }}
        </p>
        <a href="/posts" class="text-blue-500 font-medium">&laquo; Back</a>
    </article>

</x-layout>
