<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $comments = Comment::orderBy('created_at', 'desc')->get();
        return view('dashboard', ['posts' => $posts, 'comments' => $comments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'postContent' => 'required|max:1000'
        ]);
        
        $post = new Post();
        $post->postContent = $validatedData['postContent'];
        $message = 'There was an error';
        if ($request->user()->posts()->save($post)) {
            $message = 'Post was successfully created!';
        };

        return redirect()->route('dashboard')->with(['message' => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('id', $id)->first();
        $comments = Comment::orderBy('created_at', 'desc')->get();
        $user_id = Auth::user()->id;
        if ($post == null) {
            return redirect()->route('dashboard')->with(['message' => 'Successfully deleted!']);
        }
        return view('posts.show', ['show' => $id, 'post' => $post, 'comments' => $comments, 'user_id' => $user_id]);
    }

    public function apiCommentsIndex($id)
    {
        // $comments = Comment::all();
        $comments = Comment::with('user')->where('post_id', $id)->get();
        return $comments;
    }

    public function apiCommentsStore(Request $request, $id)
    {
        $c = new Comment();
        $c->commentBody = $request['commentBody'];
        $c->post_id = $id;
        $c->user_id = $request['user_id'];
        $c->save();
        return $comments = Comment::with('user')->where('post_id', $id)->get();;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'postContent' => 'required'
        ]);
        $post = Post::find($request['Id']);
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->postContent = $request['postContent'];
        $post->update();
        return response()->json(['new_body' => $post->postContent], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->delete();
        return redirect()->back()->with(['message' => 'Successfully deleted!']);
    }
}
