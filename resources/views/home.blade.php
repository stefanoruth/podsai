@extends('app')

@section('body')
	<div id="app">
		<navbar></navbar>
		<audio-player></audio-player>
		<main class="container mx-auto pb-8 mb-8">
			<router-view></router-view>
		</main>
	</div>

	@routes
	<script src="{{ mix('app.js') }}"></script>
@stop