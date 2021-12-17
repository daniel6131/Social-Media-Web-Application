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
                        <form action="{{ route('post.create') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <span class="text-gray-500 font-medium">What do you have to say?</span>
                                <textarea class="bg-gray-200 w-full rounded-lg shadow border p-2" rows="5" 
                                    placeholder="Speak your mind" name="postContent" id="postContent" class="form-control" 
                                    value="{{ old('postContent') }}"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="media" class="text-gray-500 font-medium">Maybe upload an image accompany:</label>
                                <input type="file" name="media" class="form-control" id="media">
                            </div>
                            <div class="form-group">
                                <button class="px-4 py-1 text-sm text-indigo-600 font-semibold rounded-full border border-indigo-200 
                                hover:text-white hover:bg-indigo-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-600 
                                focus:ring-offset-2">Create Post</button>
                                <input type="hidden" value="{{ Session::token() }}" name="_token">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-3 flex flex-col">
                    @foreach($posts as $post)
                        <div class="bg-white mt-3">
                            @if (Storage::disk('local')->has($post->mediaPath))
                                <img class="border rounded-t-lg shadow-lg" src="{{ route('post.media', ['mediaPath' => $post->mediaPath]) }}">
                            @endif
                            <div class="bg-white border shadow p-5" data-postid="{{ $post->id }}">
                                <div class="flex justify-between mb-1">
                                    <a href="{{ route('post.show', ['id' => $post->id]) }}" class="text-xl text-gray-700 font-semibold">
                                        {{ $post->postContent }}
                                    </a>
                                    @auth
                                        @if($user->id == $post->postable->user->id or $userType == "AdminProfile")
                                            <div>
                                                <a href="#" class="modal-open ml-2 mt-1 mb-auto text-sm px-4 py-2 leading-none border rounded 
                                                text-indigo-500 border-indigo-500 hover:border-transparent hover:text-white hover:bg-indigo-500 
                                                mt-4 lg:mt-0">
                                                    Edit
                                                </a>
                                                <a href="{{ route('post.destroy', ['id' => $post->id]) }}" class="ml-2 mt-1 mb-auto text-sm px-4 
                                                    py-2 leading-none border rounded text-indigo-500 border-indigo-500 hover:border-transparent 
                                                    hover:text-white hover:bg-indigo-500 mt-4 lg:mt-0">
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
                                                    <a href="{{ route('user.show', ['id' => $comment->commentable->user->id]) }}">
                                                        {{ $comment->commentable->user->name }}
                                                    </a>
                                                </div>
                                                <p class="text-gray-600 text-lg text-center md:text-left ">{{ $comment->commentBody }}</p>
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

    <script>
        var token = '{{ Session::token() }}';
        var url = '{{ route('post.update') }}';
    </script>

@endsection
