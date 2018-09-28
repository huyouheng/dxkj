<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;

class InnerApiController extends Controller
{
	public function getUserRoleById($id)
	{
		if (!is_numeric($id)) {
			return null;
		}

		$user = User::getUserById($id);
		if (!$user) {
			return null;
		}

		return response()->json($user->roles);
	}

	public function getRolePerById($id)
	{
		if (!is_numeric($id)) {
			return null;
		}

		$role = Role::getDataById($id);
		if (!$role) {
			return null;
		}

		return response()->json($role->permissions);
	}
}