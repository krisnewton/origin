@extends('layouts.app')

@section('page_title', 'Reset Password')

@section('content')
	<x-card-small>
		<x-title>Reset Password</x-title>

		<form method="POST" action="{{ route('password.update') }}">
			@csrf
			<input type="hidden" name="token" value="{{ $token }}">

			<x-form-group-text label="E-Mail" name="email" id="fieldEmail" :value="$email ?? old('email')" :message="$errors->first('email')"/>

			<x-form-group-text type="password" label="Password Baru" name="password" id="fieldPassword" :value="old('password')" :message="$errors->first('password')"/>

			<x-form-group-text type="password" label="Ulangi Password" name="password_confirmation" id="fieldPasswordConfirmation" :value="old('password_confirmation')" :message="$errors->first('password_confirmation')"/>

			<button type="submit" class="btn btn-primary btn-block">Reset Password</button>
		</form>
	</x-card-small>
@endsection