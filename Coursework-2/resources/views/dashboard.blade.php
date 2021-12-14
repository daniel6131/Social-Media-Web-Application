@extends('layouts.app')

@section('content')

    <div class="w-full flex flex-row flex-wrap">
        <div class="w-full flex flex-row flex-wrap justify-center">
            <div class="w-full md:w-3/4 lg:w-4/5 p-5 md:px-12 lg:24 h-full">
                <div class="bg-white w-full shadow rounded-lg p-5">
                    <div class="text-center space-y-2 sm:text-left">
                        <div class="space-y-0.5">
                            <p class="text-lg text-black font-semibold">
                                ChitChat
                            </p>
                        </div>
                        <form action="{{ route('post.create') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <span class="text-gray-500 font-medium">What do you have to say?</span>
                                <textarea class="bg-gray-200 w-full rounded-lg shadow border p-2" rows="5" 
                                    placeholder="Speak your mind" name="postContent" id="postContent" value="{{ old('postContent') }}"></textarea>
                                <button class="px-4 py-1 text-sm text-indigo-600 font-semibold rounded-full border border-indigo-200 hover:text-white hover:bg-indigo-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">Create Post</button>
                                <input type="hidden" value="{{ Session::token() }}" name="_token">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-3 flex flex-col">
                    @foreach($posts as $post)
                        <div class="bg-white mt-3">
                            <div class="bg-white border shadow p-5" data-postid="{{ $post->id }}">
                                <a href="{{ route('post.show', ['id' => $post->id]) }}" class="text-xl text-gray-700 font-semibold">{{ $post->postContent }}</a>
                                <div class="text-gray-500 font-medium font-size:small">
                                    Posted by:
                                    <a href="{{ route('user.show', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a> 
                                    on {{ $post->created_at->toFormattedDateString() }}
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
                                                    <a href="{{ route('user.show', ['id' => $comment->user->id]) }}">{{ $comment->user->name }}</a>
                                                </div>
                                                <p class="font-medium font-size:small">{{ $comment->commentBody }}</p>
                                            </div>
                                        </div>
                                        @break
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
