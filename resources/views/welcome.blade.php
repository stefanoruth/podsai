@extends('master')

@section('body')
    <div class="h-screen bg-pattern flex justify-center items-center">
        <div class="max-w-md w-full p-4">
            <div class="text-purple bg-white shadow rounded-lg border p-4">
                <div class="flex justify-between items-center mb-16">
                    <a class="font-light text-5xl no-underline">Podsai</a>
                    <a href="{{ url('login') }}" class="bg-purple-dark no-underline text-white rounded-sm text-lg px-4 py-2">Log In</a>
                </div>
                <h1 class="font-semibold text-2xl mb-6">Your favorite podcasts everywhere.</h1>
                <div class="text-xl font-thin">
                    <p class="mb-3">The podcast application works as a progressive web app. (PWA)</p>
                    <p>It can be installed on youre mobile device and shares podcasts across youre computer and phone. So you always have the latest episodes right at your hand.</p>
                </div>
            </div>
        </div>
    </div>
@stop