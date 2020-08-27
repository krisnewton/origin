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
			<table class="w-100 table table-sm table-bordered table-hover" id="usersIndex">
				<thead class="thead-light">
					<tr>
						<th class="w-25">Nama</th>
						<th class="w-25 desktop">Email</th>
						<th class="desktop">Role</th>
						<th class="desktop">Terdaftar</th>
						<th class="desktop">Action</th>
						<th>Timestamp</th>
					</tr>
				</thead>
			</table>
		</div>
	</x-card-large>
@endsection

@push('styles')
	<link rel="stylesheet" href="{{ asset('vendor/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/datatables/Responsive-2.2.5/css/responsive.dataTables.min.css') }}">
@endpush

@push('scripts')
	<script src="{{ asset('vendor/datatables/DataTables-1.10.21/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('vendor/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('vendor/datatables/Responsive-2.2.5/js/dataTables.responsive.min.js') }}"></script>
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