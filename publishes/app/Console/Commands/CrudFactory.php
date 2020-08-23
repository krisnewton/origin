<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Crud;
use Illuminate\Support\Facades\DB;

class CrudFactory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name : Nama class} {display_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Buat CRUD';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$name = $this->argument('name'); // User
    	$name_snake = strtolower(Str::snake($name)); // user
    	$name_snake_plural = Str::plural($name_snake); // users

    	$display_name = $this->argument('display_name');

    	// Buat Accesses
    	$id = DB::table('access_groups')->insertGetId([
    		'name' => $display_name
    	]);

    	$accesses = [
    		$name_snake_plural . '.index' 		=> 'Melihat Daftar ' . $display_name,
    		$name_snake_plural . '.create' 		=> 'Buat ' . $display_name,
    		$name_snake_plural . '.edit' 		=> 'Edit ' . $display_name,
    		$name_snake_plural . '.show' 		=> 'Melihat Detail ' . $display_name,
    		$name_snake_plural . '.destroy' 	=> 'Hapus ' . $display_name
    	];

    	foreach ($accesses as $access_code => $access_name) {
    		DB::table('accesses')->insert([
    			'access_group_id' 	=> $id,
    			'name' 				=> $access_name,
    			'code' 				=> $access_code
    		]);
    	}
    	// [END] Buat Accesses

        // $this->callSilent('make:migration', [
        // 	'name' => 'create_' . $name_snake_plural . '_table'
        // ]);

        $this->append_route($name, $name_snake_plural);

        $this->create_model($name);
        $this->create_controller($name, $name_snake, $name_snake_plural, $display_name);

        $this->views_generator($name_snake, $name_snake_plural, $display_name);
    }

    public function get_stub($type)
    {
    	$stub = file_get_contents(resource_path('stubs/' . $type . '.stub'));
    	return $stub;
    }

    public function append_route($name, $name_snake_plural)
    {
    	$routes = file_get_contents(base_path('routes/web.php'));
    	$routes .= "\r\n";
    	$routes .= "Route::resource('" . $name_snake_plural . "', 'Apps\\" . $name . "Controller');";
    	file_put_contents(base_path('routes/web.php'), $routes);
    }

    public function create_model($name)
    {
    	$model = str_replace(
    		['{{name}}'],
    		[$name],
    		$this->get_stub('Model')
    	);

    	file_put_contents(app_path($name . '.php'), $model);
    }

    public function create_controller($name, $name_snake, $name_snake_plural, $display_name)
    {
    	$validation = $this->validation_generator($name_snake_plural);
    	$file_uploader = $this->file_uploader($name_snake_plural);
    	$file_remover = $this->file_remover($name_snake_plural, $name_snake);

    	$controller = str_replace(
    		['{{name}}', '{{name_snake}}', '{{name_snake_plural}}', '{{display_name}}', '{{validation}}', '{{file_uploader}}', '{{file_remover}}'],
    		[$name, $name_snake, $name_snake_plural, $display_name, $validation, $file_uploader, $file_remover],
    		$this->get_stub('Controller')
    	);

    	if (!file_exists(app_path('Http/Controllers/Apps'))) {
    		mkdir(app_path('Http/Controllers/Apps'), 0777, true);
    	}

    	file_put_contents(app_path('Http/Controllers/Apps/' . $name . 'Controller.php'), $controller);
    }

    public function views_generator($name_snake, $name_snake_plural, $display_name)
    {
		if (!file_exists(resource_path('views/apps'))) {
    		mkdir(resource_path('views/apps'), 0777, true);
		}

		if (!file_exists(resource_path('views/apps/' . $name_snake_plural))) {
    		mkdir(resource_path('views/apps/' . $name_snake_plural), 0777, true);
		}

		$this->form_generator($name_snake, $name_snake_plural);

		$configs = Crud::where('name', $name_snake_plural)->first();
		$configs = $configs->config;
		$configs = json_decode($configs, true);

		$table_heads = [];
		$table_cols = [];
		$details = [];
		foreach ($configs as $config) {
			$config_display_name 	= $config[0];
			$config_form_name 		= $config[1];
			$config_type 			= $config[2];
			$config_validation		= $config[3];

			$table_heads[] = '<th>' . $config_display_name . '</th>';
			$table_cols[] = '<td>{{ $' . $name_snake . '->' . $config_form_name . ' }}</td>';
			$details[] = '<tr><th>' . $config_display_name . '</th><td>{{ $' . $name_snake . '->' . $config_form_name . ' }}</td></tr>';
		}
		$table_heads = implode(' ', $table_heads);
		$table_cols = implode(' ', $table_cols);
		$details = implode(' ', $details);

		// Index
    	$view_index_stub = $this->get_stub('views/index.blade');
    	$view_index = str_replace(
    		['{{name_snake}}', '{{name_snake_plural}}', '{{display_name}}', '{{table_heads}}', '{{table_cols}}'],
    		[$name_snake, $name_snake_plural, $display_name, $table_heads, $table_cols],
    		$view_index_stub
    	);
    	file_put_contents(resource_path('views/apps/' . $name_snake_plural . '/index.blade.php'), $view_index);
    	// [END] Index

    	// Create
    	$view_create_stub = $this->get_stub('views/create.blade');
    	$view_create = str_replace(
    		['{{name_snake}}', '{{name_snake_plural}}', '{{display_name}}'], 
    		[$name_snake, $name_snake_plural, $display_name],
    		$view_create_stub
    	);
    	file_put_contents(resource_path('views/apps/' . $name_snake_plural . '/create.blade.php'), $view_create);
    	// [END] Create

    	// Show
    	$view_show_stub = $this->get_stub('views/show.blade');
    	$view_show = str_replace(
    		['{{display_name}}', '{{details}}'],
    		[$display_name, $details],
    		$view_show_stub
    	);
    	file_put_contents(resource_path('views/apps/' . $name_snake_plural . '/show.blade.php'), $view_show);
    	// [END] Show

    	// Edit
    	$view_edit_stub = $this->get_stub('views/edit.blade');
    	$view_edit = str_replace(
    		['{{display_name}}', '{{name_snake_plural}}', '{{name_snake}}'],
    		[$display_name, $name_snake_plural, $name_snake],
    		$view_edit_stub
    	);
    	file_put_contents(resource_path('views/apps/' . $name_snake_plural . '/edit.blade.php'), $view_edit);
    	// [END] Edit
    }

    public function form_generator($name_snake, $name_snake_plural)
    {
    	// Create Form
    	$path = resource_path('views/apps/' . $name_snake_plural . '/partials');
    	if (!file_exists($path)) {
    		mkdir($path, 0777, true);
    	}

    	$configs = Crud::where('name', $name_snake_plural)->first();

    	$output = '@csrf' . "\r\n";
    	if ($configs) {
    		$configs = $configs->config;
    		$configs = json_decode($configs, true);

    		foreach ($configs as $config) {
    			$display_name 	= $config[0];
    			$form_name 		= $config[1];
    			$type 			= $config[2];
    			$validation		= $config[3];

    			switch ($type) {
    				case 'text':
    					$value = '$' . $name_snake . ' ? $' . $name_snake . '->' . $form_name . ' : old(\'' . $form_name . '\')';
    					$output .= '<x-form-group-text label="' . $display_name . '" name="' . $form_name . '" id="field_' . $form_name . '" :value="' . $value . '" :message="$errors->first(\'' . $form_name . '\')"/>' . "\r\n";
    					break;
    				case 'textarea':
    					$value = '$' . $name_snake . ' ? $' . $name_snake . '->' . $form_name . ' : old(\'' . $form_name . '\')';
    					$output .= '<x-form-group-textarea label="' . $display_name . '" name="' . $form_name . '" id="field_' . $form_name . '" :value="' . $value . '" :message="$errors->first(\'' . $form_name . '\')"/>' . "\r\n";
    					break;
    				case 'file':
    					$output .= '@if ($' . $name_snake . ')' . "\r\n";
    					$output .= '	<div class="row mb-2">' . "\r\n";
    					$output .= '		<div class="col-12 col-md-6">' . "\r\n";
    					$output .= '			<img src="{{ asset(\'storage/\' . $' . $name_snake . '->' . $form_name . ') }}" alt="' . $display_name . '" class="img-fluid">' . "\r\n";
    					$output .= '		</div>' . "\r\n";
    					$output .= '	</div>' . "\r\n";
    					$output .= '@endif' . "\r\n";
    					$output .= '<x-file label="' . $display_name . '" id="field_' . $form_name . '" name="' . $form_name . '" :message="$errors->first(\'' . $form_name . '\')"/>' . "\r\n";
    					break;
    				case 'select':
    					$value = '$' . $name_snake . ' ? $' . $name_snake . '->' . $form_name . ' : old(\'' . $form_name . '\')';
    					$output .= '<x-form-group-select label="' . $display_name . '" name="' . $form_name . '" id="field_' . $form_name . '" :value="' . $value . '" :message="$errors->first(\'' . $form_name . '\')" :options="[]"/>' . "\r\n";
    					break;
    			}
    		} // [END] Foreach
    	}
    	$output .= '<button class="btn btn-primary">Simpan</button>';

    	file_put_contents($path . '/form.blade.php', $output);
    	// [END] Create Form
    }

    public function validation_generator($name_snake_plural)
    {
    	$configs = Crud::where('name', $name_snake_plural)->first();
    	$configs = $configs->config;
    	$configs = json_decode($configs, true);

    	$output = '';

    	foreach ($configs as $config) {
			$display_name 	= $config[0];
			$form_name 		= $config[1];
			$type 			= $config[2];
			$validations	= $config[3];

			$joined = [];
			foreach ($validations as $validation) {
				$joined[] = '\'' . $validation . '\'';
			}

			$joined = implode(', ', $joined);

    		$output .= '\'' . $form_name . '\' => [' . $joined . '], ';
    	}

    	return $output;
    }

    public function file_uploader($name_snake_plural)
    {
    	$configs = Crud::where('name', $name_snake_plural)->first();
    	$configs = $configs->config;
    	$configs = json_decode($configs, true);

    	$output = '';

    	foreach ($configs as $config) {
			$display_name 	= $config[0];
			$form_name 		= $config[1];
			$type 			= $config[2];
			$validations	= $config[3];

			if ($type == 'file') {
				$output .= 'if ($request->hasFile(\'' . $form_name . '\')) {' . "\r\n";
				$output .= '	$path = $request->' . $form_name . '->store(\'' . $name_snake_plural . '\', \'public\');' . "\r\n";
				$output .= '	$data[\'' . $form_name . '\'] = $path;' . "\r\n";
				$output .= '}' . "\r\n";
			}
    	}

    	return $output;
    }

    public function file_remover($name_snake_plural, $name_snake)
    {
		$configs = Crud::where('name', $name_snake_plural)->first();
    	$configs = $configs->config;
    	$configs = json_decode($configs, true);

    	$output = '';

    	foreach ($configs as $config) {
			$display_name 	= $config[0];
			$form_name 		= $config[1];
			$type 			= $config[2];
			$validations	= $config[3];

			if ($type == 'file') {
				$output .= 'if ($request->isMethod(\'delete\') || $request->hasFile(\'' . $form_name . '\')) {' . "\r\n";
				$output .= '	Storage::disk(\'public\')->delete($' . $name_snake . '->' . $form_name . ');' . "\r\n";
				$output .= '}' . "\r\n";
			}
    	}

    	return $output;
    }
}
