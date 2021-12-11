@extends('layouts.app')

@section('title')
    Post including the following: {{$comment}}
@endsection

@section('content')
    @if($comment)
        <p>This page will show the comments that belong to a post: {{$comment}}.</p>
    @else
        <h1>No comment!</h1>
    @endif
@endsection