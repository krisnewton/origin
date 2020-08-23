@csrf
<x-form-group-text label="Nama Role" name="name" id="fieldName" :value="$role ? $role->name : old('name')" :message="$errors->first('name')"/>
<button class="btn btn-primary">Simpan</button>