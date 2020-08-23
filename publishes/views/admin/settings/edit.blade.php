@extends('layouts.app')

@section('page_title')
	Pengaturan {{ $setting->name }}
@endsection

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="lg"/>
	<x-card-large>
		<x-title>Pengaturan {{ $setting->name }}</x-title>

		<form action="{{ route('settings.edit', ['setting' => $setting]) }}" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			@foreach ($setting->setting_values()->orderBy('position', 'asc')->get() as $setting_value)
				@php
					$extra = json_decode($setting_value->extra);
					if (old('_token')) {
						$val = old($setting_value->form_name);
					}
					else {
						$val = $setting_value->value;
					}
				@endphp

				@switch($extra->type)
					@case('text')
						<x-form-group-text :label="$setting_value->name" :name="$setting_value->form_name" :id="'setting' . $setting_value->id" :value="$val" :message="$errors->first($setting_value->form_name)"/>
						@break
					
					@case('textarea')
						<x-form-group-textarea :label="$setting_value->name" :name="$setting_value->form_name" :id="'setting' . $setting_value->id" :value="$val" :message="$errors->first($setting_value->form_name)"/>
						@break
					
					@case('image')
						@if (!empty($setting_value->value))
							<div class="row mb-2">
								<div class="col col-12 col-md-6">
									<img src="{{ $setting_value->value }}" class="img-fluid">
								</div>
							</div>
						@endif

						<x-file :id="'setting' . $setting_value->id" :name="$setting_value->form_name" :message="$errors->first($setting_value->form_name)" :label="$setting_value->name"/>
						@break

					@default
						<p class="text-danger">Kesalahan</p>
				@endswitch
			@endforeach
			<button type="submit" class="btn btn-primary btn-block">Simpan</button>
		</form>
	</x-card-large>
@endsection
