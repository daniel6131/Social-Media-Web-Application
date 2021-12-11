@extends('layouts.app')

@section('title', 'Comment Details')

@section('content')

    <ul>
        <li>Comment: {{$comment->commentBody}}</li>
        <li>Associated Post: {{$comment->post->postTitle}}</li>
        <li>Associated User: {{$comment->user->name}}</li>
    </ul>

@endsection