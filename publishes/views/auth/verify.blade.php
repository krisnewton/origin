@extends('layouts.app')

@section('page_title', 'Verifikasi Alamat E-Mail')

@section('content')
	<x-card-small>
		<x-title>Verifikasi Alamat E-Mail</x-title>

		@if (session('resent'))
			<x-alert type="success">
				E-mail verifikasi yang baru telah dikirim
			</x-alert>
		@endif

		<p>
			E-mail harus terverifikasi sebelum melanjutkan. 
			Jika belum menerima e-mail verifikasi, klik tombol di bawah untuk mengirim ulang.
		</p>

		<form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
			@csrf
			<button type="submit" class="btn btn-outline-secondary">Kirim Ulang</button>
		</form>
	</x-card-small>
@endsection