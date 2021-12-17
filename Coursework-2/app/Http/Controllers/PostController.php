<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
        $user = auth()->user();
        $posts = Post::latest()->get();
        $comments = Comment::latest()->get();
        if($user !== null)
        {
            if($user->UserProfile !== null)
            {
                $userType = "UserProfile";
            }
            else
            {
                $userType = "AdminProfile";
            }
            return view('dashboard', ['posts' => $posts, 'comments' => $comments, 'userType' => $userType, 'user' => $user]);
        }
        else
        {
            return view('welcome');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'postContent' => 'required|max:1000'
        ]);
        
        $p = new Post();
        $p->postContent = $validatedData['postContent'];
        $media = $request->file('media');
        
        if ($user->userProfile !== null)
        {
            $p->postable_id = $user->userProfile->id;
            $p->postable_type = "App\Models\UserProfile";
        }
        else
        {
            $p->postable_id = $user->adminProfile->id;
            $p->postable_type = "App\Models\AdminProfile";
        }

        if ($media)
        {
            $mediaPath = $request->media->hashName();
            $request->validate([
                'media' => 'mimes:jpeg,png',
            ]);

            Storage::disk('local')->put($mediaPath, File::get($media));

            // $request->file->store('user_files', 'public');
            $p->mediaPath = $mediaPath;
        }

        $p->save();

        return redirect()->route('dashboard');
    }

    public function getPostMedia($mediaPath)
    {
        $media = Storage::disk('local')->get($mediaPath);
        return new Response($media, 200);
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
        $comments = Comment::latest()->get();
        if ($post == null) {
            return redirect()->route('dashboard')->with(['message' => 'Successfully deleted!']);
        }
        $user = auth()->user();
        if($user !== null)
        {
            if($user->UserProfile !== null)
            {
                $userType = "UserProfile";
                $userId = $user->userProfile->id;
            }
            else
            {
                $userType = "AdminProfile";
                $userId = $user->adminProfile->id;
            }
            return view('posts.show', ['show' => $id, 'post' => $post, 'comments' => $comments, 'userType' => $userType, 'userId' => $userId]);
        }
        else
        {
            return view('welcome');
        }
    }

    public function apiCommentsIndex($id)
    {
        $comments = Comment::with('commentable')->where('post_id', $id)->get();
        return $comments;
    }

    public function apiCommentsStore(Request $request, $id)
    {
        $validatedData = $request->validate([
            "commentBody" => "required|max:200",
            "user_id" => "required|integer",
            "user_type" => "required|max:12"
        ]);

        $c = new Comment();
        $c->commentBody = $validatedData['commentBody'];

        if ($validatedData["user_type"] == "UserProfile")
        {
            $c->commentable_type = "App\Models\UserProfile";
        }
        else
        {
            $c->commentable_type = "App\Models\AdminProfile";
        }

        $c->post_id = $id;
        $c->commentable_id = $validatedData['user_id'];
        $c->save();

        return $comments = Comment::with('commentable')->where('post_id', $id)->get();
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
        $user = auth()->user();
        if ($user == $post->postable->user or $user->AdminProfile !== null) {
            $post->postContent = $request['postContent'];
            $post->update();
            return response()->json(['new_body' => $post->postContent], 200);
        }
        else {
            return redirect()->back()->with(['message' => 'Successfully deleted!']);
        }
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
        $user = auth()->user();
        if ($user == $post->postable->user or $user->AdminProfile !== null) {
            $post->delete();
            return redirect()->back()->with(['message' => 'Successfully deleted!']);
        } else {
            return redirect()->back();
        }
    }
}
