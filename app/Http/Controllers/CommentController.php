<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

//    public function index(Request $request){
//        $comments = Comment::with(['user'])->where('commentable_id', $request->postID)->orderby('created_at', 'desc')->paginate(4);
//        if($request->page > $comments->lastPage()){
//            $view = '';
//            return response()->json(['html'=>$view, 'isLoaded'=>true]);
//        }
//        if($request->ajax()){
//            $view = view('public.commentsshow',compact('comments'))->render();
//            return response()->json(['html'=>$view , 'isLoaded'=>false]);
//        }
//        return view('public.view-blogs',compact('comments'));
//    }
//
//    public function show(Request $request){
//        $comments = Comment::with(['user','replies.user'])->where('commentable_id', $request->postID)
//            ->whereNull('parent_id')
//            ->orderBy('created_at', 'desc')
//            ->paginate(10);
//        return view('public.show',compact('comments'));
//    }

    Public function store(Request $request){
        $data = $request->validate([
            'comment' => 'required',
        ]);
        $userId = auth()->user()->id;
        $postId = $request->post_id;
        $data['user_id'] = $userId;
        $data['post_id'] = $postId;
        $post = Post::find($postId);
        $comment = Comment::create([
            'comment' => $data['comment'],
            'user_id' => $userId,
            'commentable_id'=>$postId,
            'commentable_type'=>Post::class,
        ]);
        return redirect()->route('blogs.show', $post->slug)->with('success', 'Comment posted');

    }

    public function reply(Request $request){
        $data = $request->validate([
            'reply' => 'required',
        ]);
        $userId = auth()->user()->id;
        $postId = $request->post_id;
        $parentId = $request->comment_id;
        $data['user_id'] = $userId;
        $data['post_id'] = $postId;
        $data['parent_id'] = $parentId;
        $post = Post::find($postId);
        $comment = Comment::create([
            'comment' => $data['reply'],
            'user_id' => $userId,
            'commentable_id'=>$postId,
            'parent_id'=>$parentId,
            'commentable_type'=>Post::class,
        ]);
        return redirect()->route('blogs.show', $post->slug)->with('success', 'reply  posted');
    }
}
