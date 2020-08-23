@extends('layouts.app')

@section('page_title', 'Ganti Password')

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="md"/>
	<x-card-medium>
		<x-title>Ganti Password</x-title>

		@if (session('success'))
			<x-alert type="success">
				{{ session('success') }}
			</x-alert>
		@endif

		<form action="{{ route('account.password') }}" method="POST">
			@csrf
			@method('PUT')
			<x-form-group-text type="password" label="Password Sekarang" name="current_password" id="fieldCurrentPassword" :message="$errors->first('current_password')"/>
			<hr>
			<x-form-group-text type="password" label="Password Baru" name="password" id="fieldPassword" :message="$errors->first('password')"/>
			<x-form-group-text type="password" label="Konfirmasi Password" name="password_confirmation" id="fieldPasswordConfirmation" :message="$errors->first('password_confirmation')"/>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</form>
	</x-card-medium>
@endsection
