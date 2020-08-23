@extends('layouts.app')

@section('page_title', 'Reset Password')

@section('content')
	<x-card-small>
		<x-title>Reset Password</x-title>

		@if (session('status'))
			<x-alert type="success">
				{{ session('status') }}
			</x-alert>
		@endif

		<form method="POST" action="{{ route('password.email') }}">
			@csrf

			<x-form-group-text label="E-Mail" name="email" id="fieldEmail" :value="old('email')" :message="$errors->first('email')"/>

			<button type="submit" class="btn btn-primary btn-block">Reset Password</button>
		</form>

		<hr>
		<a href="{{ route('login') }}">&laquo; Masuk</a>
	</x-card-small>
@endsection