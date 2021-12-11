@extends('layouts.app')

@section('title')
    Users
@endsection

@section('content')
    <p>The users on the site:</p>
    <ul>
        @foreach ($users as $user)
            <li><a href="/users/{{$user->id}}">{{$user->name}}</a></li>
        @endforeach
    </ul>
    

@endsection