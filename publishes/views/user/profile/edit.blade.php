@extends('layouts.app')

@section('page_title')
	Edit Profil
@endsection

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="md"/>
	<x-card-medium>
		<x-title>Edit Profil</x-title>

		<form action="{{ route('profile.edit') }}" method="POST">
			@csrf
			@method('PUT')
			<x-form-group-text label="Name" name="name" id="fieldName" :value="old('_token') ? old('name') : $user->name" :message="$errors->first('name')"/>
			<x-form-group-text label="Email" name="email" id="fieldEmail" :value="old('_token') ? old('email') : $user->email" :message="$errors->first('email')"/>
			<button class="btn btn-primary">Simpan</button>
		</form>
	</x-card-medium>
@endsection
