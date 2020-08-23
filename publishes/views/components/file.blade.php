<div class="form-group">
	@if (!empty($label))
		<div class="mb-2">{{ $label }}</div>
	@endif
	<div class="custom-file">
		<input type="file" class="custom-file-input {{ $invalid ? 'is-invalid' : '' }}" id="{{  $id }}" name="{{  $name }}">
		<label class="custom-file-label" for="{{  $id }}">Pilih file</label>
		@if ($invalid)
			<span class="invalid-feedback">{{ $message }}</span>
		@endif
	</div>
</div>

@push('scripts')
	<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
	<script>
		$(document).ready(function () {
			bsCustomFileInput.init();
		});
	</script>
@endpush