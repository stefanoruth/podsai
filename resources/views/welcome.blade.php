@extends('master')

@section('body')
    <div class="h-screen border-t-8 border-orange p-6 flex justify-center items-center">
        <div class="flex justify-center items-center flex-col max-w-sm">
            <h1 class="text-center mb-4 font-semibold text-4xl">Podsai</h1>
            <h2 class="font-light text-center mb-8 text-5xl">Your favorite podcasts everywhere</h2>
            <a href="{{ url('login') }}" class="btn-primary px-6 py-4">Continue with Google</a>
        </div>
    </div>
@stop