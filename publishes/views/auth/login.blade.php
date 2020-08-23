@extends('layouts.app')

@section('page_title', 'Masuk')

@section('content')
	<x-card-small>
		<x-title>Masuk</x-title>

		<form method="POST" action="{{ route('login') }}">
			@csrf

			<x-form-group-text label="E-Mail" name="email" id="fieldEmail" :value="old('email')" :message="$errors->first('email')"/>

			<x-form-group-text type="password" label="Password" name="password" id="fieldPassword" :value="old('password')" :message="$errors->first('password')"/>

			@php
				if (old('_token')) {
					if (old('remember')) {
						$checked = true;
					}
					else {
						$checked = false;
					}
				}
				else {
					$checked = true;
				}
			@endphp
			<div class="form-group">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" name="remember" class="custom-control-input" id="checkboxRemember" {{ $checked ? 'checked' : '' }}>
					<label class="custom-control-label" for="checkboxRemember">Tetap masuk</label>
				</div>
			</div>

			<button type="submit" class="btn btn-primary btn-block">Masuk</button>
		</form>

		@if (Route::has('password.request'))
			<hr>
			<a href="{{ route('password.request') }}">Lupa Password</a>
		@endif
	</x-card-small>
@endsection