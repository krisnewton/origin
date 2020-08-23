@csrf
<x-form-group-text label="Nama" name="name" id="fieldName" :value="$user ? $user->name : old('name')" :message="$errors->first('name')"/>
<x-form-group-text label="Email" name="email" id="fieldEmail" :value="$user ? $user->email : old('email')" :message="$errors->first('email')"/>

@if (!empty($edit) && $edit)
	<hr>
	<p>
		<small class="text-secondary">Kosongi password jika tidak ingin dirubah</small>
	</p>
@endif

<x-form-group-text type="password" label="Password" name="password" id="fieldPassword" :value="old('password')" :message="$errors->first('password')"/>
<x-form-group-text type="password" label="Konfirmasi Password" name="password_confirmation" id="fieldPasswordConfirmation" :value="old('password_confirmation')" :message="$errors->first('password_confirmation')"/>

@if (!empty($edit) && $edit)
	<hr>
@endif

<x-form-group-select label="Role" name="role_id" id="fieldRole" :value="$user ? $user->role_id : old('role_id')" :message="$errors->first('role_id')" :options="$roles"/>
<button type="submit" class="btn btn-primary">Simpan</button>