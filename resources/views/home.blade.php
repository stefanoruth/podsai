@extends('app')

@section('body')
	<div id="app">
		<navbar></navbar>
		<main class="section">
			<div class="container">
				<router-view></router-view>
			</div>
		</main>
		<audio-player :episode-id="episode"></audio-player>
	</div>

	@routes
	<script src="{{ mix('app.js') }}"></script>
@stop