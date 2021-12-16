@extends('layouts.app')

@section('layouts.navigation')

@stop

@section('components.modal')

@stop

@section('content')
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form action="{{ route('user.store') }}" method="post">
                @csrf
                <div>
                    <select name="type" class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm">
                        <option value="admin" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2">Admin</option>
                        <option value="user" class="text-sm hover:bg-gray-100 text-gray-700 block px-4 py-2">User</option>
                    </select>
                {{-- </div>
                <div class="mt-6">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <div class="mt-1">
                    <input type="text" name="username" id="username" class="px-3 py-2 border shadow-sm border-gray-300 placeholder-gray-400  disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1 invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500 disabled:shadow-none">
                    </div>
                </div>
                <div class="mt-6">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                    <input type="email" name="email" id="email" class="px-3 py-2 border shadow-sm border-gray-300 placeholder-gray-400  disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1 invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500 disabled:shadow-none">
                    </div>
                </div>
                <div class="mt-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                    <input type="password" name="password" id="password" class="px-3 py-2 border shadow-sm border-gray-300 placeholder-gray-400  disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1 invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500 disabled:shadow-none">
                    </div>
                </div> --}}
                <div class="mt-6 text-right">
                    <button class="bg-indigo-700 hover:bg-indigo-800 px-5 py-2.5 text-sm leading-5 rounded-md font-semibold text-white">
                    Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/@themesberg/flowbite@latest/dist/flowbite.bundle.js"></script>
@endsection