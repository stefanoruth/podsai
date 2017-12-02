@extends('app')

@section('body')
    <div class="h-screen border-t-4 bg-pattern border-grey p-6 flex justify-center items-center">
        <div class="flex justify-center items-center flex-col max-w-sm">
            <h1 class="text-center mb-4 font-semibold text-4xl">Podsai</h1>
            <h2 class="font-light text-center mb-8 text-5xl">Your favorite podcasts everywhere.</h2>
            <a href="{{ url('login') }}" class="max-w-xs no-underline px-6 py-4 text-center border-grey bg-grey rounded-lg text-white block hover:border-grey-darker hover:bg-grey-dark">Continue with Google</a>
        </div>
    </div>
@stop