@extends('layouts.app')

@section('page_title', 'Ganti Avatar')

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="md"/>
	<x-card-medium>
		<x-title>Ganti Avatar</x-title>

		<x-avatar :url="$user->avatar()" size="200"/>
		<hr>

		<form action="{{ route('avatar.edit') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<x-file id="fieldAvatar" name="avatar" :message="$errors->first('avatar')"/>
			<button type="submit" class="btn btn-primary">Simpan</button>
		</form>
	</x-card-medium>
@endsection
