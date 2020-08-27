<div class="form-group">
	<label for="{{ $id }}">{{ $label }}</label>
	<textarea name="{{ $name }}" id="{{ $id }}" class="form-control {{ $invalid ? 'is-invalid' : '' }} rich-text-editor" style="height: 500px;" {{ $attributes }}>{{ $value }}</textarea>
	@if ($invalid)
		<span class="invalid-feedback">{{ $message }}</span>
	@endif
</div>

@push('styles')
	<script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
	<script>
		function isJSON (str) {
			try {
				JSON.parse(str);
			}
			catch (e) {
				return false;
			}
			return true;
		}

		tinymce.init({
			selector: ".rich-text-editor",
			plugins: "searchreplace code hr link lists wordcount image imagetools",
			menubar: "edit view",
			menu: {
				edit: { title: "Edit", items: "cut copy paste | selectall | searchreplace" },
				view: { title: "View", items: "code | visualaid" }
			},
			toolbar: "undo redo | h2 blockquote bullist numlist hr | link unlink image | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify",
			image_uploadtab: true,
			images_upload_handler: function (blobInfo, success, failure, progress) {
				var xhr, formData;
				xhr = new XMLHttpRequest();
				xhr.withCredentials = false;
				xhr.open("POST", "{{ route('upload_image') }}");
				var token = "{{ csrf_token() }}";
				xhr.setRequestHeader("X-CSRF-Token", token);
				xhr.onload = function () {
					var json;
					if (xhr.status != 200) {
						failure("HTTP Error: " + xhr.status);
						return;
					}

					if (isJSON(xhr.responseText)) {
						json = JSON.parse(xhr.responseText);
					}
					else {
						failure("Gambar tidak valid");
						return;
					}

					if (!json || typeof json.location != 'string') {
						failure("Invalid JSON: " + xhr.responseText());
						return;
					}

					success(json.location);
				};
				formData = new FormData();
				formData.append("image", blobInfo.blob(), blobInfo.filename());
				xhr.send(formData);
			},
			relative_urls: false,
			remove_script_host: false,
			document_base_url: "{{ asset('') }}"
		});
	</script>
@endpush