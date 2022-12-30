<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index() {
        $posts = Post::OrderBy('id')->paginate();
        

        return view('admin.posts.index', compact('posts'));
    }

    public function create() {
        return view('admin.posts.create');
    }

    public function store(StoreUpdatePost $request) {
        $data = $request->all();
        
        if ($request->image->isValid()) {
            $nameFile = str::of($request->title)->slug('-').'.'.$request->image->getClientOriginalExtension();
            $image = $request->image->storeAs('posts', $nameFile);
            $data['image'] = $image;
        }

        Post::create($data);
        
        return redirect()->route('posts.index')
                         ->with('message', 'Post Criado com Sucesso');;
    }
    
    public function show($id) {
        $post = Post::find($id);
        if(!isset($post)) { //Se nao tiver ou o id for errado, retorne para pagina inicial
            return redirect()->route('posts.index');
        }
        
        return view('admin.posts.show', compact('post'));
    }

    public function destroy($id) {
        if(!$post = Post::find($id)) {
            return redirect()->route('posts.index');
            
        } 
        if(Storage::exists($post->image)) {
            Storage::delete($post->image);
        }
        $post->delete();
        return redirect()->route('posts.index')
                         ->with('message', 'Post Deletado com Sucesso');

    }

    public function edit($id) {
        $post = Post::find($id);
        if(!isset($post)) {
            return redirect()->back();
        }
        return view('admin.posts.edit', compact('post'));
    }

    public function update(StoreUpdatePost $request, $id)
    {
        $data = $request->all();
        
        $post = Post::find($id);
        if(!isset($post)) {
            return redirect()->back()
                ->with('Falha ao encontrar Post para edição');
        }
        
        if ($request->image && $request->image->isValid()) {
            if(Storage::exists($post->image)) {
               Storage::delete($post->image);
            
                $nameFile = Str::of($request->title)->slug('-').'.'.$request->image->getClientOriginalExtension();
            
                $image = $request->image->storeAs('posts', $nameFile);
                $data['image'] = $image;
            }
        }

       $post->update($data);

       return redirect()->route('posts.index')
                        ->with('message', 'Post Atualizado com Sucesso');
    }

    public function search(Request $request) {
       $filters = $request->except('_token');
        $posts = Post::where('title', 'Like', "%$request->search%")
                        ->orWhere('content', 'Like', "%{$request->search}%")
                        ->paginate();
        
                        return view('admin.posts.index', compact('posts', 'filters'));
    }
}
