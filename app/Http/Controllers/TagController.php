<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request){
        $tags = Tag::all();
        if($request->ajax()){
            return response()->json($tags);
        }
        return view('tags.index', compact('tags'));
    }


    public function store(StoreTagRequest $request){

        $data = $request->validated();
        $tag = Tag::create($data);
        if($tag){
            return response()->json($tag);
        }

        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');

    }


    public function edit($id){
        $tag = Tag::findorfail($id);
        return view('tags.edit', compact('tag'));
    }
    public function update(Request $request, $id){

        $tag = Tag::findorfail($id);
        $tag->update(['name' => $request->name]);
        return response()->json(['status' => 'success']);
    }


    public function destroy($id){
        $tag = Tag::findorfail($id)->delete($id);
        return response()->json();
    }


}
