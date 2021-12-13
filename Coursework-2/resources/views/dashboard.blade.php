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
                                <p class="text-xl text-gray-700 font-semibold">{{ $post->postContent }}</p>
                                <div class="text-gray-500 font-medium font-size:small">
                                    Posted by: {{ $post->user->name }}
                                </div>
                                <div class="bg-white p-1 border shadow flex flex-row flex-wrap">
                                    <div class="w-1/4 hover:bg-gray-200 text-center text-s text-gray-700 font-semibold">Like</div>
                                    <div class="w-1/4 hover:bg-gray-200 border-l-4 border-r- text-center text-s text-gray-700 font-semibold">Comment</div>
                                    @if(Auth::user() == $post->user)
                                        <a href="#" class="modal-open w-1/4 hover:bg-gray-200 border-l-4 border-r- text-center text-s text-gray-700 font-semibold">Edit</a>
                                        <a href="{{ route('post.destroy', ['id' => $post->id]) }}" class="w-1/4 hover:bg-gray-200 border-l-4 text-center text-s text-gray-700 font-semibold">Delete</a>
                                    @endif
                                </div>
                                <div class="bg-white border-4 bg-gray-300 border-white rounded-b-lg shadow p-5 text-gray-700 content-center flex flex-row flex-wrap">
                                    <div class="w-full">
                                        <div class="w-full text-left text-xl font-semibold text-gray-600">
                                            @Some Person
                                        </div>
                                        <p class="font-medium font-size:small">That's a pretty cool post.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!--Modal-->
    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

            <!-- Add margin if you want to see some of the overlay behind the modal-->
            <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">Edit Post</p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>

                <!--Body-->
                <form>
                    <div class="form-group">
                        <textarea class="bg-gray-200 w-full rounded-lg shadow border p-2" name="post-body" id="post-body" rows="5"></textarea>
                    </div>
                </form>

                <!--Footer-->
                <div class="flex justify-end pt-2">
                    <button class="modal-close px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2" data-dismiss="modal">Close</button>
                    <button class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400" id="modal-save">Save Changes</button>
                </div>
        
            </div>
        </div>
    </div>

    <script>
        var token = '{{ Session::token() }}';
        var url = '{{ route('post.update') }}';
    </script>

@endsection
