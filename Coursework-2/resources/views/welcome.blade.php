@extends('layouts.app')

@section('content')

    <style>
        body {
        background: transparent;
        }
    </style>

    <section class="container mx-auto px-6 p-10">
        <h2 class="text-4xl font-bold text-center text-gray-800 mb-8">
        ChitChat
        </h2>
        <div class="welcome-info-box">
            <div class="w-full">
                <h4 class="text-3xl text-white font-bold mb-3">Free to Use</h4>
                <p class="text-white mb-8">ChitChat is completely free to use. You can post and comment whatever you care about here on ChitChat. Follow your friends to see what they're up to and they may just follow you back.</p>
            </div>
        </div>
    
        <div class="welcome-info-box">
            <div class="w-full">
                <h4 class="text-3xl text-white font-bold mb-3">Easy and Inituitive</h4>
                <p class="text-white mb-8">Our UI over here at ChitChat is easy, simple and fun to use. Our easy to navigate UI with navigation bar allows you to search each and every corner of our virtual hub with ease.</p>
            </div>
        </div>
    
        <div class="welcome-info-box">
            <div class="w-full">
                <h4 class="text-3xl text-white font-bold mb-3">Get Started</h4>
                <p class="text-white mb-8">Why waste time! Click the Register button in the top right to create an account and start chatting today. Or if you're already registered, click that Log In button to dive in!</p>
            </div>
        </div>
    </section>

@endsection
