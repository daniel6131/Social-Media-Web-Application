@extends('layouts.app')

@section('title')
    Comments
@endsection

@section('content')
    <p>The comments on the site:</p>
    <ul>
        @foreach ($comments as $comment)
            <li><a href="{{ route('comments.show', [ 'id' => $comment->id ]) }}">{{$comment->commentBody}}</a></li>
        @endforeach
    </ul>
    <a href="{{ route('comments.create')}}">Create Comment</a>

@endsection