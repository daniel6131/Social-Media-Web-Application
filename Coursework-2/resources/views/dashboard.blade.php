@extends('layouts.app')

@section('content')

    <div class="w-full flex flex-row flex-wrap">
        <div class="w-full bg-indigo-100 h-screen flex flex-row flex-wrap justify-center">
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
                                <button class="px-4 py-1 text-sm text-purple-600 font-semibold rounded-full border border-purple-200 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">Create Post</button>
                                <input type="hidden" value="{{ Session::token() }}" name="_token">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-3 flex flex-col">
                    <div class="bg-white mt-3">
                        <div class="bg-white border shadow p-5 text-xl text-gray-700 font-semibold">
                            A Pretty Cool post.
                        </div>
                        <div class="bg-white p-1 border shadow flex flex-row flex-wrap">
                            <div class="w-1/4 hover:bg-gray-200 text-center text-s text-gray-700 font-semibold">Like</div>
                            <div class="w-1/4 hover:bg-gray-200 border-l-4 border-r- text-center text-s text-gray-700 font-semibold">Comment</div>
                            <div class="w-1/4 hover:bg-gray-200 border-l-4 border-r- text-center text-s text-gray-700 font-semibold">Edit</div>
                            <div class="w-1/4 hover:bg-gray-200 border-l-4 text-center text-s text-gray-700 font-semibold">Delete</div>
                        </div>
                        <div class="bg-white border-4 bg-gray-300 border-white rounded-b-lg shadow p-5 text-gray-700 content-center flex flex-row flex-wrap">
                            <div class="w-full">
                                <div class="w-full text-left text-xl font-medium text-gray-600">
                                    @Some Person
                                </div>
                                <p class="font-small">That's a pretty cool post.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
