<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="{{ route('home') }}">{{ setting('app.name') }}</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
				<a class="nav-link" href="{{ route('home') }}">Beranda</a>
			</li>
			@guest
				<li class="nav-item {{ Route::currentRouteName() == 'login' ? 'active' : '' }}">
					<a class="nav-link" href="{{ route('login') }}">Masuk</a>
				</li>
				@if (Route::has('register'))
					<li class="nav-item {{ Route::currentRouteName() == 'register' ? 'active' : '' }}">
						<a class="nav-link" href="{{ route('register') }}">Daftar</a>
					</li>
				@endif
			@else
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{ Auth::user()->name }} <span class="caret"></span>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{ route('profile.my_profile') }}">Profil</a>
						<a class="dropdown-item" href="{{ route('account.password') }}">Ganti Password</a>
						
						<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</div>
				</li>
			@endguest
		</ul>
	</div>
</nav>