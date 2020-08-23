@extends('layouts.app')

@section('page_title', 'Profil Tidak Ditemukan')

@section('content')
	<x-card-large>
		<x-title>Profil Tidak Ditemukan</x-title>
		<x-alert type="warning" :closeable="false">URL profil salah. Profil tidak ditemukan.</x-alert>
	</x-card-large>
@endsection
