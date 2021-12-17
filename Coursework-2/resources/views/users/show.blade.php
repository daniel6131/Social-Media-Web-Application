@extends('layouts.app')

@section('content')
    <div class="container mx-auto my-5 p-5">
        <div class="md:flex no-wrap md:-mx-2">
            <div class="w-full md:w-3/12 md:mx-2">
                <div class="bg-white p-3 border-t-4 border-indigo-400">
                    <div class="image overflow-hidden">
                        <img class="h-auto w-full mx-auto" src="https://cdn1.iconfinder.com/data/icons/technology-devices-2/100/Profile-512.png" alt="">
                    </div>
                    <div class="my-3 text-center">
                            @if ($exists)
                                <a href="{{ route('user.unfollow', ['id' => $user->id]) }}" class="flex-shrink-0 bg-indigo-500 hover:bg-indigo-700 border-indigo-500 hover:border-indigo-700 text-sm border-4 text-white py-1 px-2 rounded">
                                    Unfollow
                                </a>
                            @elseif ($user == Auth::user())
                            @else
                                <a href="{{ route('user.follow', ['id' => $user->id]) }}" class="flex-shrink-0 bg-indigo-500 hover:bg-indigo-700 border-indigo-500 hover:border-indigo-700 text-sm border-4 text-white py-1 px-2 rounded">
                                    Follow
                                </a>
                            @endif
                    </div>
                    <h1 class="text-gray-900 font-bold text-xl leading-8">About Me:</h1>
                    <p class="text-sm text-gray-500 hover:text-gray-600 leading-6">Lorem ipsum dolor sit amet
                        consectetur adipisicing elit.
                        Reprehenderit, eligendi dolorum sequi illum qui unde aspernatur non deserunt</p>
                    <ul class="bg-gray-100 text-gray-600 hover:text-gray-700 hover:shadow py-2 px-3 mt-3 divide-y rounded shadow-sm">
                        <li class="flex items-center py-3">
                            <span>Member since</span>
                            <span class="ml-auto">{{ $user->created_at->toFormattedDateString() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-full md:w-9/12 mx-2">
                <div class="flex flex-col min-w-0 bg-white w-full mb-6 shadow-xl rounded-lg">
                    <div class="flex flex-wrap justify-center py-4">
                        @auth
                            @if ($user->UserProfile !== null)
                                <div class="w-full lg:w-4/12 text-center">
                                    <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{ count($followersCount) }}</span><span class="text-sm text-blueGray-400">Followers</span>
                                </div>
                                <div class="w-full lg:w-4/12 text-center">
                                    <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{ count($postCount) }}</span><span class="text-sm text-blueGray-400">Posts</span>
                                </div>
                                <div class="w-full lg:w-4/12 text-center">
                                    <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{ count($commentCount) }}</span><span class="text-sm text-blueGray-400">Comments</span>
                                </div>
                            @else
                                <p class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">Admin</p>
                            @endif
                        @endauth
                    </div>
                    <div class="text-center">
                        <h3 class="text-4xl font-semibold leading-normal mb-2 text-blueGray-700 mb-2">
                            {{ $user->name }}
                        </h3>
                    </div>
                    <div class="mt-6 py-4 border-t border-blueGray-200">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full lg:w-11/12">
                                <div class="mt-3 flex flex-col">
                                    @foreach($posts as $post)
                                        @if($post->postable->user->id == $user->id)
                                            <div class="bg-white mt-3">
                                                @if (Storage::disk('local')->has($post->mediaPath))
                                                    <img class="border rounded-t-lg shadow-lg" src="{{ route('post.media', ['mediaPath' => $post->mediaPath]) }}">
                                                @endif
                                                <div class="bg-white border shadow p-5" data-postid="{{ $post->id }}">
                                                    <div class="flex justify-between mb-1">
                                                        <a href="{{ route('post.show', ['id' => $post->id]) }}" class="text-xl text-gray-700 font-semibold">{{ $post->postContent }}</a>
                                                        @auth
                                                            @if($user->id == $post->postable->user->id or $userType == "AdminProfile")
                                                                <div>
                                                                    <a href="#" class="modal-open ml-2 mt-1 mb-auto text-sm px-4 py-2 leading-none border rounded text-indigo-500 border-indigo-500 hover:border-transparent hover:text-white hover:bg-indigo-500 mt-4 lg:mt-0">
                                                                        Edit
                                                                    </a>
                                                                    <a href="{{ route('post.destroy', ['id' => $post->id]) }}" class="ml-2 mt-1 mb-auto text-sm px-4 py-2 leading-none border rounded text-indigo-500 border-indigo-500 hover:border-transparent hover:text-white hover:bg-indigo-500 mt-4 lg:mt-0">
                                                                        Delete
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        @endauth
                                                    </div>
                                                    <div class="text-gray-500 font-medium font-size:small">
                                                        Posted by:
                                                        <a href="{{ route('user.show', ['id' => $post->postable->user->id]) }}">{{ $post->postable->user->name }}</a> 
                                                        on {{ $post->created_at->toFormattedDateString() }}
                                                    </div>
                                                    <button class="font-bold py-2 px-4 w-full bg-indigo-500 text-lg text-white shadow-md rounded-lg ">Comment </button>
                                                    @foreach($comments as $comment)
                                                        @if($comment->post_id == $post->id)
                                                            <div class="bg-white rounded-lg p-3 shadow-lg mb-4 content-center flex flex-row flex-wrap">
                                                                <div class="w-full">
                                                                    <div class="w-full text-indigo-600 font-semibold text-xl text-left ">
                                                                        @
                                                                        <a href="{{ route('user.show', ['id' => $comment->commentable->user->id]) }}">{{ $comment->commentable->user->name }}</a>
                                                                    </div>
                                                                    <p class="text-gray-600 text-lg text-center md:text-left ">{{ $comment->commentBody }}</p>
                                                                </div>
                                                            </div>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var token = '{{ Session::token() }}';
        var url = '{{ route('post.update') }}';
    </script>
@endsection