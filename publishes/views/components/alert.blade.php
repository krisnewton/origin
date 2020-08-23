<div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
	{{ $slot }}

	@if ($closeable)
		<button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
			<span aria-hidden="true">&times;</span>
		</button>
	@endif
</div>