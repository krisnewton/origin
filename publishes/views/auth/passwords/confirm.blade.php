@extends('layouts.app')

@section('page_title', 'Konfirmasi Password')

@section('content')
	<x-card-small>
		<x-title>Konfirmasi Password</x-title>

		<p>Konfirmasi password sebelum melanjutkan.</p>

		<form method="POST" action="{{ route('password.confirm') }}">
			@csrf

			<x-form-group-text type="password" label="Password" name="password" id="fieldPassword" :value="old('email')" :message="$errors->first('password')"/>

			<button type="submit" class="btn btn-primary btn-block">Lanjutkan</button>
		</form>
	</x-card-small>
@endsection