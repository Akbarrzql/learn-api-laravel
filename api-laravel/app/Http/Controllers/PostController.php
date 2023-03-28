<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::with('user:id,username')->get();
        /*dengan menggunakan json biasa data tidak dapat di manupulasi
        sedangkan dengan menggunakan resource data dapat di manupulasi */

//        return response()->json(['data' => $post]);
        return PostDetailResource::collection($post);
    }

    public function show($id)
    {
        $post = Post::with('user:id,username,email')->find($id);
        return new PostDetailResource($post);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'news_content' => $request->news_content,
            'author' => Auth::user()->id,
        ]);

        return response()->json([
            'message' => 'berhasil menambahkan data',
            'data' => $post ->loadMissing('penulis:id,username')
        ], 201);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        if ($validator->fails()){
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        $post = Post::find($id);
        $post->update([
            'title' => $request->title,
            'news_content' => $request->news_content,
        ]);

        return response()->json([
            'message' => 'berhasil menambahkan data',
            'data' => $post ->loadMissing('user:id,username')
        ], 201);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        return response()->json([
            'message' => 'berhasil menghapus data',
        ], 200);
    }

}
