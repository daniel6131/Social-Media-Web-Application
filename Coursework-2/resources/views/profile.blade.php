@extends('layouts.app')

@section('title')
    My Profile
@endsection

@section('content')
    <style>
        body {
        background-color: #E2E8F0;
        }
    </style>
    <div class="container mx-auto my-5 p-5">
        <div class="md:flex no-wrap md:-mx-2">
            <div class="w-full md:w-3/12 md:mx-2">
                <div class="bg-white p-3 border-t-4 border-green-400">
                    <div class="image overflow-hidden">
                        <img class="h-auto w-full mx-auto" src="https://lavinephotography.com.au/wp-content/uploads/2017/01/PROFILE-Photography-112.jpg" alt="">
                    </div>
                    <h1 class="text-gray-900 font-bold text-xl leading-8 my-1">About Me:</h1>
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
                <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg">
                    <div class="flex flex-wrap justify-center py-4">
                        <div class="w-full lg:w-4/12 text-center">
                            <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">22</span><span class="text-sm text-blueGray-400">Followers</span>
                        </div>
                        <div class="w-full lg:w-4/12 text-center">
                            <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{ count($postCount) }}</span><span class="text-sm text-blueGray-400">Posts</span>
                        </div>
                        <div class="w-full lg:w-4/12 text-center">
                            <span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600">{{ count($comments) }}</span><span class="text-sm text-blueGray-400">Comments</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-4xl font-semibold leading-normal mb-2 text-blueGray-700 mb-2">
                            {{ $user->name }}
                        </h3>
                    </div>
                    <div class="mt-6 py-4 border-t border-blueGray-200 text-center">
                        <div class="flex flex-wrap justify-center">
                            <div class="w-full lg:w-11/12">
                                <div class="mt-3 flex flex-col">
                                    @foreach($posts as $post)
                                        @if($post->user_id == $user->id)
                                            <div class="bg-white mt-3">
                                                <div class="bg-white border shadow p-5" data-postid="{{ $post->id }}">
                                                    <p class="text-xl text-gray-700 font-semibold">{{ $post->postContent }}</p>
                                                    <div class="bg-white p-1 border shadow flex flex-row flex-wrap">
                                                        <div class="w-1/4 hover:bg-gray-200 text-center text-s text-gray-700 font-semibold">Like</div>
                                                        <div class="w-1/4 hover:bg-gray-200 border-l-4 border-r- text-center text-s text-gray-700 font-semibold">Comment</div>
                                                        @if(Auth::user() == $post->user)
                                                            <a href="#" class="modal-open w-1/4 hover:bg-gray-200 border-l-4 border-r- text-center text-s text-gray-700 font-semibold">Edit</a>
                                                            <a href="{{ route('post.destroy', ['id' => $post->id]) }}" class="w-1/4 hover:bg-gray-200 border-l-4 text-center text-s text-gray-700 font-semibold">Delete</a>
                                                        @endif
                                                    </div>
                                                    @foreach($comments as $comment)
                                                        @if($comment->post_id == $post->id)
                                                            <div class="bg-white border-4 bg-gray-300 border-white rounded-b-lg shadow p-5 text-gray-700 content-center flex flex-row flex-wrap">
                                                                <div class="w-full">
                                                                    <div class="w-full text-left text-xl font-semibold text-gray-600">
                                                                        {{ $comment->user->name }}
                                                                    </div>
                                                                    <p class="font-medium font-size:small">{{ $comment->commentBody }}</p>
                                                                </div>
                                                            </div>
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
@endsection