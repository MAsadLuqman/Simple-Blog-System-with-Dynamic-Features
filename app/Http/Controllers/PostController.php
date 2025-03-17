<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(){
        $posts = Post::with(['tags','user']);
        $tags = Tag::all();
        if(auth()->user()->roles->first()->name == 'user'){
            $posts = $posts->where('user_id', auth()->id());
        }
        $posts = $posts->paginate(3);
        return view('posts.index',compact('posts','tags'));
    }
    public function deleteImage($post)
    {
        $path = storage_path('app/public/images/post_img/' . $post->image);
        if (file_exists($path)) {
            return unlink($path);
        }
        return false;
    }
    public function create(){
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
    }
    public function store(StorePostRequest $request){

       $data =  $request->validated();
        $userID= auth()->user()->id;
        $imageName = time().'.'.$request->image->extension();
        $image = $request->file('image');
        $image->storeAs('images/post_img', $imageName, ['disk' => 'public']);
        $slug = Str::of($request->title)->slug('-');
        $data['image'] = $imageName;
        $data['slug'] = $slug;
        $data['user_id'] = $userID;
        $post = Post::create($data);

        $post->tags()->sync($request->tags);
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }
    public function show($slug){
        $post = Post::with(['tags','user','comments.user'])->where('slug', $slug)->first();
        $last_post = Post::latest()->paginate(5);
        if(!$post){abort(404);}
        return view('posts.show', compact(['post','last_post']));
    }
    public function edit($id){
        $tags = Tag::all();
        $post = Post::findorfail($id);

        return view('posts.edit', compact(['post', 'tags']));
    }
    public function update(UpdatePostRequest $request, $id){
        $post = Post::findorfail($id);
       $data = $request->validated();
        $imageName = $post->image;
        if($request->hasFile('image')){
            if( !empty($imageName)){
                $this->deleteImage($post);
            }
            $imageName = time().'.'.$request->image->extension();
            $image = $request->file('image');

            $image->storeAs('images/post_img', $imageName, ['disk' => 'public']);
        }
        $data['image'] = $imageName;
        $slug = Str::of($request->title)->slug('-');
        $data['slug'] = $slug;

        $post->update($data);
        $post->tags()->sync($request->tags);
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }
    public function destroy($id){
        $post = Post::findorfail($id);
        $this->deleteImage($post);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
    public function search(Request $request){
        $posts = Post::query();
        if(auth()->user()->roles()->first()->name != 'admin'){

            $posts = $posts->where('user_id',auth()->user()->id);

        }
        if($request->title){
            $posts = $posts->where('title', 'like', '%'.$request->title.'%');
        }

        if($request->date){

            $startDate=Carbon::parse($request->date)->format('Y-m-d H:i:s');
            $endDate=$request->date. " 23:59:59";
            $posts->WhereBetween('created_at',[$startDate,$endDate]);
        }


        $posts = $posts->get();
        return view('posts.search', compact('posts'));
    }
    public function toggleStatus($id)
    {
        $post = Post::findorfail($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        $post->is_published = !$post->is_published;
        $post->save();
        return response()->json([
            'message' => 'Post status updated successfully',
            'is_published' => $post->is_published,
        ]);
    }

    public function tableview(Request $request){
        $posts = Post::with(['tags','user'])->get();
        $tags = Tag::all();
        if($request->type === 'gird-view-btn'){
           return view('posts.gird-view', compact('posts', 'tags'));

        }
        if($request->type === 'table-view-btn'){
            return view('posts.tableview', compact('posts'));
        }

    }

}
