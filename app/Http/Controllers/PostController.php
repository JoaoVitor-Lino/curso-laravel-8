<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;

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
        
        Post::create($request->all());
        
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

    public function update(StoreUpdatePost $request, $id) {
        $post = Post::find($id);
        if (!isset($post)) {
            return redirect()->back();
        }
       $post->update($request->all());

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
