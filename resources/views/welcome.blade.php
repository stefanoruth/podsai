@extends('master')

@section('body')
    <div class="h-screen bg-purple flex justify-center items-center">
        <div class="max-w-md w-full text-white py-6 px-4">
            <div class="flex justify-between items-center mb-screen-1/5">
                <a class="font-bold text-5xl no-underline">Podsai</a>
                <a href="{{ url('login') }}" class="bg-purple-dark no-underline text-white rounded-sm text-lg px-4 py-2">Log In</a>
            </div>
            <h1 class="font-semibold text-3xl mb-6">Your favorite podcasts everywhere.</h1>
            <div class="text-xl">
                <p class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                <p>Illo quam amet quos debitis temporibus quo aperiam! Mollitia beatae pariatur, alias laboriosam aperiam natus velit odit nostrum voluptatibus rerum et esse?</p>
            </div>
        </div>
    </div>
@stop