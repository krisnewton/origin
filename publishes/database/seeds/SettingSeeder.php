<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$extra = [
    		'type' => 'text',
    		'validation' => ['required']
    	];
    	$extra = json_encode($extra);

    	// Setting Aplikasi
    	$name = 'Aplikasi';
    	DB::table('settings')->insert([
    		'name' 		=> $name,
    		'slug' 		=> Str::slug($name, '-'),
    		'position' 	=> 1
    	]);

        DB::table('setting_values')->insert([
        	'setting_id' 	=> 1,
        	'code' 			=> 'app.name',
        	'form_name'		=> 'app_name',
        	'name' 			=> 'Nama Aplikasi',
        	'value' 		=> 'Laravel',
        	'position' 		=> 1,
        	'extra'			=> $extra
        ]);

        DB::table('setting_values')->insert([
        	'setting_id' 	=> 1,
        	'code' 			=> 'app.description',
        	'form_name'		=> 'app_description',
        	'name' 			=> 'Deskripsi Aplikasi',
        	'value' 		=> 'Hello, World!',
        	'position' 		=> 2,
        	'extra'			=> $extra
		]);
		
        DB::table('setting_values')->insert([
        	'setting_id' 	=> 1,
        	'code' 			=> 'app.logo',
        	'form_name'		=> 'app_logo',
        	'name' 			=> 'Logo Aplikasi',
        	'value' 		=> '',
        	'position' 		=> 3,
        	'extra'			=> json_encode([
				'type' => 'image', 
				'edit' => [
					'resize' => [100, 100]
				]
			])
		]);

        // Setting Style
    	$name = 'Style';
    	DB::table('settings')->insert([
    		'name' 		=> $name,
    		'slug' 		=> Str::slug($name, '-'),
    		'position' 	=> 2
    	]);

        DB::table('setting_values')->insert([
        	'setting_id' 	=> 2,
        	'code' 			=> 'style.small_class',
        	'form_name'		=> 'style_small_class',
        	'name' 			=> 'Small container class',
        	'value' 		=> 'col-12 col-lg-8',
        	'position' 		=> 1,
        	'extra'			=> $extra
        ]);

        DB::table('setting_values')->insert([
        	'setting_id' 	=> 2,
        	'code' 			=> 'style.medium_class',
        	'form_name'		=> 'style_medium_class',
        	'name' 			=> 'Medium container class',
        	'value' 		=> 'col-12 col-lg-10',
        	'position' 		=> 2,
        	'extra'			=> $extra
        ]);

        DB::table('setting_values')->insert([
        	'setting_id' 	=> 2,
        	'code' 			=> 'style.large_class',
        	'form_name'		=> 'style_large_class',
        	'name' 			=> 'Large container class',
        	'value' 		=> 'col-12 col-lg-12',
        	'position' 		=> 3,
        	'extra'			=> $extra
        ]);
    }
}
