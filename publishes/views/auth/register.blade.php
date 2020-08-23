@extends('layouts.app')

@section('page_title', 'Daftar')

@section('content')
	<x-card-small>
		<x-title>Daftar</x-title>

		<form method="POST" action="{{ route('register') }}">
			@csrf

			<x-form-group-text label="Nama" name="name" id="fieldName" :value="old('name')" :message="$errors->first('name')"/>

			<x-form-group-text label="E-Mail" name="email" id="fieldEmail" :value="old('email')" :message="$errors->first('email')"/>

			<x-form-group-text type="password" label="Password" name="password" id="fieldPassword" :value="old('password')" :message="$errors->first('password')"/>

			<x-form-group-text type="password" label="Ulangi Password" name="password_confirmation" id="fieldPasswordConfirmation" :value="old('password_confirmation')" :message="$errors->first('password_confirmation')"/>

			<button type="submit" class="btn btn-primary btn-block">Daftar</button>
		</form>
	</x-card-small>
@endsection