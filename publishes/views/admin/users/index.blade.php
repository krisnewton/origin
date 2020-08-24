@extends('layouts.app')

@section('page_title', 'Pengguna')

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="lg"/>
	<x-card-large>
		<x-title>Pengguna</x-title>

		@can('access', 'users.create')
			<div class="text-right">
				<a href="{{ route('users.create') }}" class="btn btn-primary">Buat Pengguna Baru</a>
			</div>
			<hr>
		@endcan

		@if (session('success'))
			<x-alert type="success">
				{{ session('success') }}
			</x-alert>
		@endif

		@if (session('danger'))
			<x-alert type="danger">
				{{ session('danger') }}
			</x-alert>
		@endif

		<div class="table-responsive p-2">
			<table class="w-100 table table-bordered table-hover" id="usersIndex">
				<thead class="thead-light">
					<tr>
						<th class="w-50">Nama</th>
						<th class="desktop">Email</th>
						<th class="none">Role</th>
						<th class="none">Terdaftar</th>
						<th class="none">Action</th>
						<th>Timestamp</th>
					</tr>
				</thead>
			</table>
		</div>
	</x-card-large>
@endsection

@push('styles')
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">
@endpush

@push('scripts')
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
	<script>
		$(document).ready(function () {
			$("#usersIndex").DataTable({
				"responsive" : true,
				"pagingType" : "simple",
				"processing" : true,
				"serverSide" : true,
				"ajax" : "{{ route('users.datatables') }}",
				"columnDefs" : [
					{ "targets" : 0, "data" : "name" },
					{ "targets" : 1, "data" : "email" },
					{ "targets" : 2, "data" : "role", "searchable" : false },
					{ "targets" : 3, "data" : "created_at", "orderData" : 5, "searchable" : false },
					{ "targets" : 4, "data" : "action", "orderable" : false, "searchable" : false },
					{ "targets" : 5, "data" : "timestamp", "visible" : false }
				]
			});
		});
	</script>
@endpush