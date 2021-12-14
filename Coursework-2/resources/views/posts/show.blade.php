@extends('layouts.app')

@section('content')

    <div class="w-full flex flex-row flex-wrap">
        <div class="w-full flex flex-row flex-wrap justify-center">
            <div class="w-full md:w-3/4 lg:w-4/5 p-5 md:px-12 lg:24 h-full">
                <div class="bg-white mt-3">
                    <div class="bg-white border shadow p-5" data-postid="{{ $post->id }}">
                        <a href="{{ route('post.show', ['id' => $post->id]) }}" class="text-xl text-gray-700 font-semibold">{{ $post->postContent }}</a>
                        <div class="text-gray-500 font-medium font-size:small">
                            Posted by: {{ $post->user->name }}
                        </div>
                        <div class="bg-white p-1 border shadow flex flex-row flex-wrap">
                            <div class="w-1/4 hover:bg-gray-200 text-center text-s text-gray-700 font-semibold">Like</div>
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
            </div>
        </div>
    </div>

@endsection