<div class="form-group">
    <label for="{{ $id }}">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $id }}" class="form-control {{ $invalid ? 'is-invalid' : '' }}">{{ $value }}</textarea>
	@if ($invalid)
		<span class="invalid-feedback">{{ $message }}</span>
	@endif
</div>