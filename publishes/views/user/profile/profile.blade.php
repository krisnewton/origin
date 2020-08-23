@extends('layouts.app')

@section('page_title')
	Profil {{ $user->name }}
@endsection

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="md"/>
	<x-card-medium>
		<x-title>Profil {{ $user->name }}</x-title>
		<div class="form-row">
			<div class="col-12 col-md-3">
				<x-avatar :url="$user->avatar()"/>

				@auth
					@if ($user->id == Auth::user()->id)
						<div class="text-center mt-2">
							<a href="{{ route('avatar.edit') }}">Ganti Avatar</a>
						</div>
					@endif
				@endauth
			</div>
			<div class="col-12 col-md-9">
				<hr class="d-md-none">
				<h3 class="h5">{{ $user->name }}</h3>
				<div>
					Bergabung sejak {{ $user->created_at->diffForHumans() }}<br>
				</div>

				@auth
					@if ($user->id == Auth::user()->id)
						<div>
							<a href="{{ route('profile.edit') }}">Edit Profil</a>
						</div>
					@endif
				@endauth
			</div>
		</div>
	</x-card-medium>
@endsection
