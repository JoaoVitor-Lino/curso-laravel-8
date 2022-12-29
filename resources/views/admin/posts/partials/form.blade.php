@if ($errors->any())
<ul>    
    @foreach ($errors as $erro)
        <li>{{$erro}}</li>
    @endforeach
</ul>
@endif

@csrf
<input type="text" name="title" id="title" placeholder="Titulo" value="{{$post->title ?? old('title') }}">
<textarea name="content" id="content" cols="30" rows="4" placeholder="Conteudo"> {{$post->content ?? old('title') }} </textarea>
<button type="submit">Enviar</button>