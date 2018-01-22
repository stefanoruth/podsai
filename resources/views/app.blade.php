@extends('master')

@section('body')
	<div id="app">
		<navbar></navbar>
		<audio-player></audio-player>
		<main>
			<router-view></router-view>
		</main>
	</div>

	@routes
	<script async src="{{ mix('app.js') }}"></script>
@stop