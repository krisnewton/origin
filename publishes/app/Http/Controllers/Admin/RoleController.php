<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\User;

class RoleController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth']);
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$this->authorize('access', 'roles.index');

    	$breadcrumb = [
    		'Role' => ''
    	];

    	$roles = Role::get();

        return view('admin.roles.index', compact('breadcrumb', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$this->authorize('access', 'roles.create');

    	$breadcrumb = [
    		'Role' 			=> route('roles.index'),
    		'Buat Role' 	=> ''
    	];
        return view('admin.roles.create', compact('breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$this->authorize('access', 'roles.create');

        $data = $request->validate([
        	'name' => ['required', 'max:255']
        ]);

        Role::create($data);

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
    	$this->authorize('access', 'roles.edit');

    	$breadcrumb = [
    		'Role' 			=> route('roles.index'),
    		'Edit Role' 	=> ''
    	];
    	return view('admin.roles.edit', compact('breadcrumb', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
    	$this->authorize('access', 'roles.edit');

    	if ($role->name != $request->input('name')) {
    		$message = $role->name . ' berhasil diubah menjadi ' . $request->input('name');
    	}
    	else {
    		$message = '';
    	}

        $data = $request->validate([
        	'name' => ['required', 'max:255']
        ]);
        $role->update($data);
        return redirect()->route('roles.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
    	$this->authorize('access', 'roles.destroy');

    	$role_id = $role->id;
    	if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
    		$message = $role->name . ' tidak dapat dihapus';

    		return redirect()->route('roles.index')->with('danger', $message);
    	}
    	else {
    		$message = $role->name . ' berhasil dihapus';

    		User::where('role_id', $role->id)->update(['role_id' => 3]);

    		$role->delete();
    		return redirect()->route('roles.index')->with('success', $message);
    	}
    }
}
