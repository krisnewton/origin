<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$config = [
    		// [ Display Name, Form Name, Type, [ Validation ] ],
    	];
    	DB::table('cruds')->insert([
    		'name' 		=> 'products',
    		'config' 	=> json_encode($config)
    	]);
    }
}
