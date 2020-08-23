@extends('layouts.app')

@section('page_title', 'Buat Role')

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="lg"/>
	<x-card-large>
		<x-title>Buat Role</x-title>

		<form method="POST" action="{{ route('roles.store') }}">
			@include('admin.roles.partials.form', ['role' => ''])
		</form>
	</x-card-large>
@endsection
