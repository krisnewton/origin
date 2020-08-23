<div class="container">
	<div class="row justify-content-center">
		<div class="col {{ $size }}">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb mb-2">
					<li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
					@foreach ($links as $link_text => $link_url)
						@if (empty($link_url))
							<li class="breadcrumb-item active" aria-current="page">{{ $link_text }}</li>
						@else
							<li class="breadcrumb-item"><a href="{{ $link_url }}">{{ $link_text }}</a></li>
						@endif
					@endforeach
				</ol>
			</nav>
		</div>
	</div>
</div>