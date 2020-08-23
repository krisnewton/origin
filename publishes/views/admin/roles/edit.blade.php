@extends('layouts.app')

@section('page_title', 'Edit Role')

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="lg"/>
	<x-card-large>
		<x-title>Edit Role</x-title>

		<form method="POST" action="{{ route('roles.update', ['role' => $role]) }}">
			@method('PUT')
			@include('admin.roles.partials.form', ['role' => $role])
		</form>
	</x-card-large>
@endsection
