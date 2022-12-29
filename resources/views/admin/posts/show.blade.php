@extends('admin.layouts.app')

@section('title', 'Mostrar Posts')

@section('content')
    <h1>Detalhes do Post {{$post->title}}</h1>

    <ul>
        <li><strong>{{ $post->title }} </strong></li>
        <li><strong>{{ $post->content }} </strong></li>
    </ul>

    <form action="{{ route('posts.destroy', $post->id) }}" method="post">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit">Deletar o post {{ $post->title }}</button>
    </form>
@endsection