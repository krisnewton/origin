@extends('layouts.app')

@section('page_title', 'Pengaturan')

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="lg"/>
	<x-card-large>
		<x-title>Pengaturan</x-title>

		<div class="form-row">
			@foreach ($settings as $setting)
				<div class="col-12 col-md-4 col-lg-3">
					<a href="{{ route('settings.edit', ['setting' => $setting]) }}" class="btn btn-outline-secondary btn-block mb-2">
						{{ $setting->name }}
					</a>
				</div>
			@endforeach
		</div>
	</x-card-large>
@endsection
