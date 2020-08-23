@extends('layouts.app')

@section('page_title')
	Akses {{ $role->name }}
@endsection

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="lg"/>
	<x-card-large>
		<x-title>Akses {{ $role->name }}</x-title>

		@if (session('success'))
			<x-alert type="success">
				{{ session('success') }}
			</x-alert>
		@endif

		<div>
			<div class="custom-control custom-checkbox">
				<input type="checkbox" class="custom-control-input" id="all" {{ $all_checked ? 'checked' : '' }}>
				<label class="custom-control-label" for="all"><b>Semua</b></label>
			</div>
		</div>
		<hr>

		<form method="POST" action="{{ route('roles.accesses', ['role' => $role]) }}">
			@csrf
			@method('PUT')

			@foreach ($access_groups as $access_group)
				<div class="mb-2">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="group{{ $access_group->id }}" data-type="accessGroup" {{ $group_checked[$access_group->id] ? 'checked' : '' }}>
						<label class="custom-control-label" for="group{{ $access_group->id }}"><b>{{ $access_group->name }}</b></label>
					</div>
				</div>
				<div class="pl-3">
					@foreach ($access_group->accesses as $access)
						<x-checkbox :label="$access->name" :id="$access->code" :is-checked="in_array($access->code, $accesses)" name="accesses[]" :value="$access->code" data-type="access" :data-group="'group' . $access_group->id"/>
					@endforeach
				</div>
				<hr>
			@endforeach
			<button type="submit" class="btn btn-primary btn-block">Simpan</button>
		</form>
	</x-card-large>
@endsection

@push('scripts')
	<script>
		$(document).ready(function () {
			$("[data-type]").on("change", function () {
				var checkbox = $(this);
				var checkboxType = checkbox.data("type");

				if (checkboxType == "accessGroup") {
					var checkboxId = checkbox.attr("id");

					var value = false;
					if (checkbox.prop("checked")) {
						value = true;
					}
					else {
						value = false;
					}

					$("[data-group='" + checkboxId + "']").prop("checked", value);
				}
				else if (checkboxType == "access") {
					var group = checkbox.data("group");
					var groupTotal = $("[data-group='" + group + "']").length;
					var groupCheckedTotal = $("[data-group='" + group + "']:checked").length;

					if (groupTotal == groupCheckedTotal) {
						$("#" + group).prop("checked", true);
					}
					else {
						$("#" + group).prop("checked", false);
					}
				}

				var allCheckboxes = $("[data-type]").length;
				var allCheckedCheckboxes = $("[data-type]:checked").length;

				if (allCheckboxes == allCheckedCheckboxes) {
					$("#all").prop("checked", true);
				}
				else {
					$("#all").prop("checked", false);
				}
			});

			$("#all").on("change", function () {
				var checkbox = $(this);
				if (checkbox.prop("checked")) {
					$("[data-type]").prop("checked", true);
				}
				else {
					$("[data-type]").prop("checked", false);
				}
			});
		});
	</script>
@endpush