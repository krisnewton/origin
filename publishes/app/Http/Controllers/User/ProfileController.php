<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth'])->except(['my_profile', 'profile']);
	}

	public function my_profile(Request $request)
	{
		if (Auth::check()) {
			return redirect()->route('profile.show', ['user' => $request->user()]);
		}
		else {
			return view('user.profile.profile-not-found');
		}
	}

	public function profile(Request $request, User $user)
	{
		$breadcrumb = [
			'Profil' => ''
		];
		return view('user.profile.profile', compact('breadcrumb', 'user'));
	}

	public function edit(Request $request)
	{
		$breadcrumb = [
			'Profil' 		=> route('profile.show', ['user' => $request->user()]),
			'Edit Profil' 	=> ''
		];

		$user = $request->user();

		return view('user.profile.edit', compact('breadcrumb', 'user'));
	}

	public function update(Request $request)
	{
		$user = $request->user();
		$old_email = $user->email;

		$data = $request->validate([
			'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
			'email' => ['required', 'email', Rule::unique('users')->ignore($user)]
		]);

		$user->update($data);

		if ($old_email != $data['email']) {
			$user->update(['email_verified_at' => null]);
			$user->sendEmailVerificationNotification();
		}

		return redirect()->route('profile.show', ['user' => $user]);
	}
}
