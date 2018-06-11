@extends('master')

@section('body')
	<div id="app" class="h-screen flex flex-col overflow-hidden">
		<main class="flex-1 overflow-y-scroll relative border-purple border-t-2">
			<router-view></router-view>
		</main>
		<audio-player></audio-player>
		<navbar></navbar>
	</div>
@stop