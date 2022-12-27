{{-- <a href="/posts/create">Criar Novo Posts</a> --}}
<a href="{{ route('posts.create') }}">Criar Novo Posts</a>
<hr>

@if(session('message'))
    <div>
        {{ session('message') }}
    </div>
@endif

<h1>Posts</h1>

@foreach ($posts as $post)
    <p>
        {{$post->title}}
        [ <a href="{{ route('posts.show', $post->id) }}">Ver</a> ]
    </p>
@endforeach
