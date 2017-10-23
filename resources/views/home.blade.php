@extends('app')

@section('body')
	<div id="app">
		<navbar></navbar>
		<audio-player :episode-id="episode"></audio-player>
		<main class="section">
			<div class="container">
				<router-view></router-view>
			</div>
		</main>
	</div>

	@routes
	<script src="{{ mix('app.js') }}"></script>
@stop