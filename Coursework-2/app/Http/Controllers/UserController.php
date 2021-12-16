<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminProfile;
use App\Models\UserProfile;
use App\Models\Post;
use App\Models\Comment;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "type" => "required|max:5",
            "username" => "required|unique:user_profiles|unique:admin_profiles|max:15",
            // "bio" => "max:100"
        ]);

        if ($validatedData["type"] == "user")
        {
            $u = new UserProfile;
            // $u->bio = $validatedData["bio"];
        }
        else{
            $u = new AdminProfile;
        }

        $u->username = $validatedData["username"];
        $u->user_id = auth()->user()->id;
        $u->save();

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();

        $postCount = Post::where('postable_id', $id)->pluck('id')->toArray();
        $posts = Post::orderBy('created_at', 'desc')->get();

        $commentCount = Comment::where('commentable_id', $id)->pluck('id')->toArray();
        $comments = Comment::orderBy('created_at', 'desc')->get();
        
        $followersCount = $user->followers()->get()->toArray();
        $exists = $user->followers()->where('follower_id', Auth::user()->id)->exists();

        $thisUser = auth()->user();
        if($thisUser !== null)
        {
            if($thisUser->UserProfile !== null)
            {
                $userType = "UserProfile";
                $userId = $thisUser->userProfile->id;
            }
            else
            {
                $userType = "AdminProfile";
                $userId = $thisUser->adminProfile->id;
            }
            return view('users.show', ['show' => $id, 'postCount' => $postCount, 'commentCount' => $commentCount, 'followersCount' => $followersCount,
                                    'posts' => $posts, 'comments' => $comments, 'user' => $user, 'exists' => $exists, 'userType' => $userType, 'userId' => $userId]);
        }
        else
        {
            return view('welcome');
        }
    }

    public function follow($id) 
    {     
        $userToFollow = User::where('id', $id)->first();
        $viewingUser = User::find(Auth::user()->id);
        $viewingUser->followings()->attach($userToFollow->id);
        
        return redirect()->route('user.show', ['id' => $id]);
    }

    public function unfollow($id)
    {
        $userToUnFollow = User::where('id', $id)->first();
        $viewingUser = User::find(Auth::user()->id);
        $viewingUser->followings()->detach($userToUnFollow->id);
        
        return redirect()->route('user.show', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
