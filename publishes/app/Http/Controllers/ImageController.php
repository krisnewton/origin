<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Str;
use Grafika\Grafika;

class ImageController extends Controller
{
    public function __construct()
    {
    	$this->middleware(['auth']);
    }

    public function index(Request $request)
    {
    	$data = $request->validate([
    		'image' => ['required', 'image', 'max:2048']
    	]);

    	$data['user_id'] = $request->user()->id;

    	$extension = $request->image->extension();
    	$filename = Str::random(32) . '.' . $extension;

    	$path = $request->image->storeAs('images', $filename, 'public');

    	$data['image'] = asset('storage/' . $path);

    	// Membuat thumbnail
    	$editor = Grafika::createEditor();

    	$editor->open($image, 'storage/' . $path);
    	$editor->resizeFill($image, 256, 256);
    	$editor->save($image, 'storage/images/thumbnails/' . $filename);

    	$data['image_thumbnail'] = asset('storage/images/thumbnails/' . $filename);

        $editor->open($image2, 'storage/' . $path);
        $editor->resizeFill($image2, 300, 300);
        $editor->save($image2, 'storage/images/squares/' . $filename);
    	// [END] Membuat thumbnail

    	Image::create($data);

    	return response()->json([
    		'success' 			=> true,
    		'image' 			=> $data['image'],
    		'image_thumbnail' 	=> $data['image_thumbnail'],
    		'location' 			=> $data['image']
    	]);
    }
}
