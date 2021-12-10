@extends('layouts.app')

@section('title')
    {{$user}}'s Posts
@endsection

@section('content')
    @if($user)
        <p>This page will show the posts that belong to a user: {{$user}}.</p>
    @else
        <h1>No user!</h1>
    @endif
@endsection