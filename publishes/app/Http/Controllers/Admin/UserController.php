<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DataTables;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
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
    	$this->authorize('access', 'users.index');
    	
        $breadcrumb = [
        	'Pengguna' => ''
        ];

        $users = User::get();

        return view('admin.users.index', compact('breadcrumb'));
    }

    public function datatables(Request $request)
    {
    	$this->authorize('access', 'users.index');

    	if ($request->ajax() ||  true) {
	    	return DataTables::of(User::get())
	    		->only(['name', 'email', 'role', 'action', 'created_at', 'timestamp'])
	    		->addColumn('role', function (User $user) {
	    			return $user->role->name;
	    		})
	    		->addColumn('action', function (User $user) {
	    			$output = '<a href="' . route('profile.show', ['user' => $user]) . '" target="_blank" class="btn btn-primary btn-sm">Profil</a> ';

	    			if (Gate::allows('access', 'users.edit')) {
	    				$output .= '<a href="' . route('users.edit', ['user' => $user]) . '" class="btn btn-primary btn-sm">Edit</a>';
	    			}

	    			return $output;
	    		})
	    		->addColumn('timestamp', function (User $user) {
	    			return $user->created_at->timestamp;
	    		})
	    		->editColumn('name', function (User $user) {
	    			return $user->name();
	    		})
	    		->editColumn('created_at', function (User $user) {
	    			return $user->created_at->diffForHumans();
	    		})
	    		->rawColumns(['name', 'action'])
	    		->toJson();
    	}
    	else {
    		abort(404);
    	}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$this->authorize('access', 'users.create');

        $breadcrumb = [
        	'Pengguna' 				=> route('users.index'),
        	'Buat Pengguna Baru' 	=> ''
        ];

        $data = [];
        $roles = Role::get();
        foreach ($roles as $role) {
        	$data[$role->id] = $role->name;
        }
        $roles = $data;

        return view('admin.users.create', compact('breadcrumb', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$this->authorize('access', 'users.create');

        $data = $request->validate([
            'name' 		=> ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'email' 	=> ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' 	=> ['required', 'string', 'min:8', 'confirmed'],
            'role_id'	=> ['required', 'exists:roles,id']
        ]);

        $data['password'] = Hash::make($request->input('password'));

        $user = User::create($data);
        $user->sendEmailVerificationNotification();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
    	$this->authorize('access', 'users.edit');

        $breadcrumb = [
        	'Pengguna' 				=> route('users.index'),
        	'Edit Pengguna' 		=> ''
        ];

        $data = [];
        $roles = Role::get();
        foreach ($roles as $role) {
        	$data[$role->id] = $role->name;
        }
        $roles = $data;

        return view('admin.users.edit', compact('breadcrumb', 'user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
    	$this->authorize('access', 'users.edit');

    	$message = 'Profil ' . $user->name . ' berhasil diedit';
    	$old_email = $user->email;

        $data = $request->validate([
            'name' 		=> ['required', 'string', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'email' 	=> ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'password' 	=> ['nullable', 'string', 'min:8', 'confirmed'],
            'role_id'	=> ['required', 'exists:roles,id']
        ]);

        unset($data['password']);

        if ($request->input('password')) {
        	$password = Hash::make($request->input('password'));

        	$user->update(['password' => $password]);
        }

        $user->update($data);

        if ($old_email != $data['email']) {
        	$user->update(['email_verified_at' => null]);
        	$user->sendEmailVerificationNotification();
        }

        return redirect()->route('users.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
