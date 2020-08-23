<div class="form-group">
	<label for="{{ $id }}">{{ $label }}</label>
	<select name="{{ $name }}" id="{{ $id }}" class="custom-select {{ $invalid ? 'is-invalid' : '' }}">
		@foreach ($options as $opt_val => $opt_text)
			<option value="{{ $opt_val }}" {{ $value == $opt_val ? 'selected' : '' }}>{{ $opt_text }}</option>
		@endforeach
	</select>
	@if ($invalid)
		<span class="invalid-feedback">{{ $message }}</span>
	@endif
</div>