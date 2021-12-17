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
                    @if (Storage::disk('local')->has($post->mediaPath))
                        <img class="border rounded-t-lg shadow-lg center" src="{{ route('post.media', ['mediaPath' => $post->mediaPath]) }}">
                    @endif
                    <div class="bg-white border shadow p-5" data-postid="{{ $post->id }}">
                        <div class="flex justify-between mb-1">
                            <a href="{{ route('post.show', ['id' => $post->id]) }}" class="text-xl text-gray-700 font-semibold">{{ $post->postContent }}</a>
                            @auth
                                @if(Auth::user() == $post->postable->user or $userType == "AdminProfile")
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
                            Posted by: {{ $post->postable->user->name }}
                        </div>
                        <div class="flex flex-row flex-wrap border-b border-indigo-500 py-2"></div>
                        <div id="comment">
                            <ul>
                                <li v-for="comment in comments" class="bg-white border-4 bg-indigo-500 border-white rounded-b-lg shadow p-5 text-white">
                                    <div class="flex justify-between mb-1">
                                        <div class="w-full text-left text-xl font-semibold text-white">
                                            @{{ comment.commentBody }}
                                        </div>
                                        <button onclick="toggleCommentEdit()" v-if="{{$userType}} == 'AdminProfile' || comment.commentable.id == {{$userId}}" class="ml-2 mt-1 mb-auto text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-indigo-500 hover:bg-white mt-4 lg:mt-0">
                                            Edit
                                        </button>
                                        <form v-if="{{$userType}} == 'AdminProfile' || comment.commentable.id == {{$userId}}" method="post" action="{{ route('comments.destroy', ['id' => $show]) }}">
                                            @csrf
                                            <input style="display: none" type="text" v-bind:value="comment.id" name="commentId">
                                            <button class="ml-2 mt-1 mb-auto text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-indigo-500 hover:bg-white mt-4 lg:mt-0" type="submit">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                    <p class="font-medium font-size:small">@{{ comment.commentable.username }}</p>
                                    <form id="editComment" style="display: none" method="post" action="{{ route('comments.update', ['id' => $show]) }}" class="w-full">
                                        @csrf
                                        <div class="flex items-center border-b border-indigo-500 py-2">
                                            <input class="appearance-none bg-white border-white w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" name="commentBody" v-bind:value="comment.commentBody">
                                            <input style="display: none" type="text" v-bind:value="comment.id" name="commentId">
                                            <button class="flex-shrink-0 border rounded text-white border-white hover:border-transparent hover:text-indigo-500 hover:bg-white py-1 px-2 rounded" type="submit">
                                                Update
                                            </button>
                                            <button onclick="toggleCommentEdit()" class="flex-shrink-0 border-transparent border-4 text-white hover:text-indigo-300 text-sm py-1 px-2 rounded">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                            <form class="w-full">
                                @csrf
                                <div class="flex items-center border-b border-indigo-500 py-2">
                                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" id="commentInput" v-model="newCommentBody" placeholder="Add a comment">
                                    <button @click="createComment" class="flex-shrink-0 bg-indigo-500 hover:bg-indigo-700 border-indigo-500 hover:border-indigo-700 text-sm border-4 text-white py-1 px-2 rounded">
                                        Comment
                                    </button>
                                    <button class="flex-shrink-0 border-transparent border-4 text-indigo-500 hover:text-indigo-800 text-sm py-1 px-2 rounded">
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
        var token = '{{ Session::token() }}';
        var url = '{{ route('post.update') }}';
    </script>

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
                },
                destroyComment: function() {
                    axois.delete("{{ route ('api.comments.store', ['id' => $post->id]) }}")
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