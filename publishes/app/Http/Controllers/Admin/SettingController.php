<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use App\SettingValue;
use Grafika\Grafika;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth']);
	}

	public function index()
	{
		$this->authorize('access', 'settings');
		
    	$breadcrumb = [
    		'Pengaturan' => ''
    	];

    	$settings = Setting::orderBy('position', 'asc')->get();

		return view('admin.settings.index', compact('breadcrumb', 'settings'));
	}

	public function edit(Setting $setting)
	{
		$this->authorize('access', 'settings');

    	$breadcrumb = [
    		'Pengaturan' => route('settings.index'),
    		'Pengaturan ' . $setting->name => ''
    	];

		return view('admin.settings.edit', compact('breadcrumb', 'setting'));
	}

	public function update(Request $request, Setting $setting)
	{
		$this->authorize('access', 'settings');

		$setting_values = $setting->setting_values;
		$validations = [];

		foreach ($setting_values as $setting_value) {
			$extra = json_decode($setting_value->extra, true);

			if ($extra['type'] == 'image') {
				$validations[$setting_value->form_name] = ['file', 'max:5120', 'image'];
			}
			else {
				$validations[$setting_value->form_name] = $extra['validation'];
			}
		}

		$values = $request->validate($validations);

		// Mengolah File
		foreach ($setting_values as $setting_value) {
			$extra = json_decode($setting_value->extra, true);
			$type = $extra['type'];

			if ($type == 'image' && $request->has($setting_value->form_name)) {
				// Hapus File Lama
				Storage::disk('public')->delete('settings/' . $setting_value->form_name . '.jpeg');
				Storage::disk('public')->delete('settings/' . $setting_value->form_name . '.jpg');
				Storage::disk('public')->delete('settings/' . $setting_value->form_name . '.png');
				Storage::disk('public')->delete('settings/' . $setting_value->form_name . '.gif');
				// [END] Hapus File Lama

				$extension = $request->file($setting_value->form_name)->extension();
				$path = $request->file($setting_value->form_name)->storeAs('settings', $setting_value->form_name . '.' . $extension, 'public');

				$values[$setting_value->form_name] = asset('storage/' . $path);

				if (!empty($extra['edit'])) {
					$edit = $extra['edit'];	
				}
				else {
					$edit = [];
				}
				
				$editor = Grafika::createEditor();
				$editor->open($image, 'storage/' . $path);

				// Resize Image
				if (!empty($edit['resize'])) {
					$resize = $edit['resize'];
					$editor->resize($image, $resize[0], $resize[1], 'fill');
					$editor->save($image, 'storage/' . $path);
				}
				// [END] Resize Image

				// Crop Image
				if (!empty($edit['crop'])) {
					$crop = $edit['crop'];
					$editor->crop($image, $crop[0], $crop[1], 'center');
					$editor->save($image, 'storage/' . $path);
				}
				// [END] Crop Image
			}
		}
		// [END] Mengolah File

		foreach ($values as $form_name => $value) {
			SettingValue::where('form_name', $form_name)->update(['value' => $value]);
		}

		return redirect()->route('settings.edit', ['setting' => $setting]);
	}
}
