@extends('master')

@section('body')
	<div id="app" class="h-screen flex flex-col overflow-hidden">
		<div class="overflow-y-scroll flex-1">
			<navbar></navbar>
			<main>
				<router-view></router-view>
			</main>
		</div>
		<audio-player></audio-player>
	</div>
@stop