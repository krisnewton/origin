<div class="form-group">
	<label for="{{ $id }}">{{ $label }}</label>
	<input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" class="form-control {{ $invalid ? 'is-invalid' : '' }}" value="{{ $value }}">
	@if ($invalid)
		<span class="invalid-feedback">{{ $message }}</span>
	@endif
</div>