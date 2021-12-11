@extends('layouts.app')

@section('title', 'Create Comments')

@section('content')
    <form method="post" action="{{ route('comments.store') }}">
        @csrf
        <p>Body: <input type="text" name="commentBody"
            value="{{ old('commentBody') }}"></p>
        <input type="submit" value="Submit">
        <a href="{{ route('comments.index')}}">Cancel</a>
    </form>

@endsection