@extends('layouts.app')

@section('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" 
    integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <div class="w-full flex flex-row flex-wrap">
        <div class="w-full flex flex-row flex-wrap justify-center">
            <div class="w-full md:w-3/4 lg:w-4/5 p-5 md:px-12 lg:24 h-full">
                <div class="bg-white mt-3">
                    <div class="bg-white border shadow p-5" data-postid="{{ $post->id }}">
                        <p class="text-xl text-gray-700 font-semibold">{{ $post->postContent }}</p>
                        <div class="text-gray-500 font-medium font-size:small">
                            Posted by: {{ $post->postable->user->name }}
                        </div>
                        <div class="bg-white p-1 border shadow flex flex-row flex-wrap">
                            <div class="w-1/4 hover:bg-gray-200 text-center text-s text-gray-700 font-semibold">Like</div>
                            <div class="w-1/4 hover:bg-gray-200 border-l-4 border-r- text-center text-s text-gray-700 font-semibold">Comment</div>
                            @if(Auth::user() == $post->user)
                                <a href="#" class="modal-open w-1/4 hover:bg-gray-200 border-l-4 border-r- text-center text-s text-gray-700 font-semibold">Edit</a>
                                <a href="{{ route('post.destroy', ['id' => $post->id]) }}" class="w-1/4 hover:bg-gray-200 border-l-4 text-center text-s text-gray-700 font-semibold">Delete</a>
                            @endif
                        </div>
                        <div id="comment">
                            <ul>
                                <li v-for="comment in comments" class="bg-white border-4 bg-indigo-300 border-white rounded-b-lg shadow p-5 text-gray-700 content-center flex flex-row flex-wrap">
                                    <div class="w-full">
                                        <div class="w-full text-left text-xl font-semibold text-gray-600">
                                            @{{ comment.commentable.username }}
                                        </div>
                                        <p class="font-medium font-size:small">@{{ comment.commentBody }}</p>
                                    </div>
                                </li>
                            </ul>
                            <form class="w-full">
                                @csrf
                                <div class="flex items-center border-b border-indigo-500 py-2">
                                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" id="commentInput" v-model="newCommentBody" placeholder="Add a comment">
                                    <button @click="createComment" class="flex-shrink-0 bg-indigo-500 hover:bg-indigo-700 border-indigo-500 hover:border-indigo-700 text-sm border-4 text-white py-1 px-2 rounded" type="button">
                                        Comment
                                    </button>
                                    <button class="flex-shrink-0 border-transparent border-4 text-indigo-500 hover:text-indigo-800 text-sm py-1 px-2 rounded" type="button">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var app = new Vue({
            el: "#comment",
            data: {
                comments: [],
                newCommentBody: '',
                user_id: {{ $userId }},
                user_type: '{{ $userType }}',
            },
            methods: {
                createComment: function() {
                    axios.post("{{ route ('api.comments.store', ['id' => $post->id]) }}",
                    {
                        commentBody: this.newCommentBody,
                        user_id: this.user_id,
                        user_type: this.user_type,
                    })
                    .then(response => {
                        this.comments = response.data;
                        this.newCommentBody = ''
                    })
                    .catch(response => {
                        console.log(response);
                    })
                }
            },
            mounted() {
                axios.get("{{ route ('api.comments.index', ['id' => $post->id]) }}")
                .then( response => {
                    this.comments = response.data;
                })
                .catch(response => {
                    console.log(response);
                })
            },
        })
    </script>

@endsection