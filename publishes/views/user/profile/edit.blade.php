@extends('layouts.app')

@section('page_title')
	Edit Profil
@endsection

@section('content')
	<x-breadcrumb :links="$breadcrumb" size="md"/>
	<x-card-medium>
		<x-title>Edit Profil</x-title>

		<form action="{{ route('profile.edit') }}" method="POST">
			@csrf
			@method('PUT')
			<x-form-group-text label="Name" name="name" id="fieldName" :value="old('_token') ? old('name') : $user->name" :message="$errors->first('name')"/>
			<x-form-group-text label="Email" name="email" id="fieldEmail" :value="old('_token') ? old('email') : $user->email" :message="$errors->first('email')"/>
			<x-form-group-textarea label="Tentang" name="about" id="fieldAbout" :value="old('_token') ? old('about') : $user->about" :message="$errors->first('about')"/>

			<div class="form-group">
				<label for="fieldFacebook">Facebook</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">https://www.facebook.com/</span>
					</div>
					<input type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook" id="fieldFacebook" value="{{ old('_token') ? old('facebook') : $user->facebook }}">
					@error('facebook')
						<span class="invalid-feedback">{{ $message }}</span>
					@enderror
				</div>
			</div>

			<div class="form-group">
				<label for="fieldTwitter">Twitter</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">https://twitter.com/</span>
					</div>
					<input type="text" class="form-control @error('twitter') is-invalid @enderror" name="twitter" id="fieldTwitter" value="{{ old('_token') ? old('twitter') : $user->twitter }}">
					@error('twitter')
						<span class="invalid-feedback">{{ $message }}</span>
					@enderror
				</div>
			</div>

			<div class="form-group">
				<label for="fieldInstagram">Instagram</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">https://www.instagram.com/</span>
					</div>
					<input type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram" id="fieldInstagram" value="{{ old('_token') ? old('instagram') : $user->instagram }}">
					@error('instagram')
						<span class="invalid-feedback">{{ $message }}</span>
					@enderror
				</div>
			</div>

			<div class="form-group">
				<label for="fieldYouTube">YouTube</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">https://www.youtube.com/channel/</span>
					</div>
					<input type="text" class="form-control @error('youtube') is-invalid @enderror" name="youtube" id="fieldYouTube" value="{{ old('_token') ? old('youtube') : $user->youtube }}">
					@error('youtube')
						<span class="invalid-feedback">{{ $message }}</span>
					@enderror
				</div>
			</div>

			<button class="btn btn-primary" type="submit">Simpan</button>
		</form>
	</x-card-medium>
@endsection
