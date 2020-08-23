@extends('layouts.app')

@section('page_title', 'Edit Pengguna')

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="lg"/>
	<x-card-large>
		<x-title>Edit Pengguna</x-title>

		<form action="{{ route('users.update', ['user' => $user]) }}" method="POST">
			@method('PUT')
			@include('admin.users.partials.form', ['user' => $user, 'edit' => true])
		</form>
	</x-card-large>
@endsection