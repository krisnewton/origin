@extends('layouts.app')

@section('page_title', 'Buat Pengguna Baru')

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="lg"/>
	<x-card-large>
		<x-title>Buat Pengguna Baru</x-title>

		<form action="{{ route('users.store') }}" method="POST">
			@include('admin.users.partials.form', ['user' => ''])
		</form>
	</x-card-large>
@endsection