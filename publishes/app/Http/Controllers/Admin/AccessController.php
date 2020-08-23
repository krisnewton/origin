<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\AccessGroup;

class AccessController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth']);
	}

	public function index(Role $role)
	{
		$this->authorize('access', 'roles.accesses');
		
		$breadcrumb = [
			'Role' 			=> route('roles.index'),
			'Akses' 		=> ''
		];

		$access_groups = AccessGroup::get();

		$accesses = [];
		$role_accesses = $role->role_accesses;
		foreach ($role_accesses as $role_access) {
			$accesses[] = $role_access->code;
		}

		$group_checked = [];
		$total_accesses = 0;
		foreach ($access_groups as $access_group) {
			$total_checked = 0;

			$access_group_accesses = $access_group->accesses;
			foreach ($access_group_accesses as $access_group_access) {
				if (in_array($access_group_access->code, $accesses)) {
					$total_checked++;
				}
			}

			if ($access_group->accesses->count() == $total_checked) {
				$group_checked[$access_group->id] = true;
			}
			else {
				$group_checked[$access_group->id] = false;
			}

			$total_accesses += $access_group->accesses->count();
		}

		if ($total_accesses == count($accesses)) {
			$all_checked = true;
		}
		else {
			$all_checked = false;
		}

		return view('admin.accesses.index', compact('breadcrumb', 'role', 'access_groups', 'accesses', 'group_checked', 'all_checked'));
	}

	public function update_accesses(Request $request, Role $role)
	{
		$this->authorize('access', 'roles.accesses');

		$data = $request->validate([
			'accesses' => ['nullable']
		]);

		$role->role_accesses()->delete();

		if (!isset($data['accesses'])) {
			$data['accesses'] = [];
		}

		foreach ($data['accesses'] as $access) {
			$role->role_accesses()->create(['code' => $access]);
		}

		return redirect()->route('roles.accesses', ['role' => $role])->with('success', 'Berhasil disimpan');
	}
}
