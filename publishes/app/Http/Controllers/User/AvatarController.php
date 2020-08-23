<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Grafika\Grafika;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth']);
	}

	public function edit(Request $request)
	{
		$breadcrumb = [
			'Profil' 		=> route('profile.show', ['user' => $request->user()]),
			'Ganti Avatar' 	=> ''
		];

		$user = $request->user();

		return view('user.avatar.edit', compact('breadcrumb', 'user'));
	}

	public function update(Request $request)
	{
		$request->validate([
			'avatar' => ['required', 'file', 'max:5120', 'image']
		]);

		// Hapus File Lama
		Storage::disk('public')->delete('avatars/' . $request->user()->id . '.jpeg');
		Storage::disk('public')->delete('avatars/' . $request->user()->id . '.jpg');
		Storage::disk('public')->delete('avatars/' . $request->user()->id . '.png');
		Storage::disk('public')->delete('avatars/' . $request->user()->id . '.gif');
		// [END] Hapus File Lama

		$extension = $request->avatar->extension();

		$path = $request->avatar->storeAs('avatars', $request->user()->id . '.' . $extension, 'public');
		$path = 'storage/' . $path;
		$full_path = asset($path);

		$request->user()->update([
			'avatar' => $full_path
		]);

		$editor = Grafika::createEditor();
		$editor->open($image, $path);
		$editor->resizeFill($image, 256, 256);
		$editor->save($image, $path);

		return redirect()->back();
	}
}
