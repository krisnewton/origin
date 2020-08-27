<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<!-- Required meta tags -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
		@stack('styles')

		<title>@yield('page_title')</title>

		<style type="text/css">
			body {
				padding-top: 56px;
			}
			.w-20 {
				width: 20%;
			}
			table td {
				vertical-align: middle !important;
			}
		</style>
	</head>
	<body>
		@include('layouts.partials.navbar')

		<main class="mt-2">
			@yield('content')
		</main>

		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="{{ asset('vendor/jquery/jquery-3.5.1.min.js') }}"></script>
		<script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
		<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
		@stack('scripts')

		<!-- Optional JavaScript -->
	</body>
</html>