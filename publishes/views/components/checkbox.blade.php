<div class="custom-control custom-checkbox">
	<input type="checkbox" class="custom-control-input" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" {{ $attributes }} {{ $isChecked ? 'checked' : '' }}>
	<label class="custom-control-label" for="{{ $id }}">{{ $label }}</label>
</div>