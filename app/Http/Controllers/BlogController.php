<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        $posts = Post::with('tags','user' )->where('is_published', true)->paginate(6);

        return view('public.blogs', compact('posts'));
    }
    public function show($slug)
    {
        $post = Post::with(['tags', 'user', 'comments' => function ($query) {
                $query->with(['user', 'replies.user'])
                    ->whereNull('parent_id')
                    ->orderBy('created_at', 'asc');
            }
        ])->where('slug', $slug)->firstOrFail();
        $last_post = Post::with('tags', 'user')->latest()->paginate(5);
        return view('public.show', compact('post', 'last_post'));
    }

    public function search(Request $request){
        $posts = Post::query();
        if($request->title){
            $posts = $posts->where('title', 'like', '%'.$request->title.'%');
        }
        $posts = $posts->get();
        return view('public.blogs.search', compact('posts'));
    }

}
