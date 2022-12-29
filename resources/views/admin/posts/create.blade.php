@extends('admin.layouts.app')

@section('title', 'Criar Novo Post') 

@section('content')

    <h1>Cadastrar novo POST</h1>


    <form action="{{route('posts.store')}}" method="post">
        
        @include('admin.posts.partials.form');
    </form>

@endsection
