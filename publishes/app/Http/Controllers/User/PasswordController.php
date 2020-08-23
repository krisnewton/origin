<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth']);
	}

	public function index()
	{
		$breadcrumb = [
			'Ganti Password' => ''
		];

		return view('user.account.password.edit', compact('breadcrumb'));
	}

	public function update(Request $request)
	{
		$data = $request->validate([
			'current_password' => ['required', 'password'],
			'password' 	=> ['required', 'string', 'min:8', 'confirmed']
		]);

		$new_password = Hash::make($request->input('password'));

		$request->user()->update(['password' => $new_password]);

		$breadcrumb = [
			'Ganti Password' => ''
		];

		return view('user.account.password.success', compact('breadcrumb'));
	}
}
