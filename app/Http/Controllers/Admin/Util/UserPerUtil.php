<?php
/**
 * Created by PhpStorm.
 * User: hyh
 * Date: 18-7-31
 * Time: 下午2:31
 */

namespace App\Http\Controllers\Admin\Util;


class UserPerUtil
{
	public static function getPermission($user)
	{
		$permissions = [];
		$tmp = [];

		$roles = $user->roles;
		foreach ($roles as $role) {
			$ps = $role->permissions;
			foreach ($ps as $p) {
				if (!in_array($p->display_name, $tmp)) {
					$permissions [] = $p;
					$tmp[] = $p->display_name;
				}
			}
		}
		unset($tmp);
		return $permissions;
	}
}