@extends('layouts.app')

@section('page_title', 'Ganti Password')

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="md"/>
	<x-card-medium>
		<x-title>Ganti Password</x-title>

		<x-alert type="success" :closeable="false">Password berhasil diganti</x-alert>

		<a href="{{ route('home') }}" class="btn btn-outline-primary">&laquo; Beranda</a>
	</x-card-medium>
@endsection
