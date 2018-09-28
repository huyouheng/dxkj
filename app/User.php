<?php

namespace App;

use App\Models\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;


	protected $fillable = [
		'name', 'email', 'password', 'last_login'
	];


	protected $hidden = [
		'password', 'remember_token', 'pivot', 'updated_at'
	];

	public static function hasUser($name)
	{
		if (is_null($user = self::where('name', $name)->first())) {
			return false;
		}
		return $user;
	}

	public static function getUsers($count = 20)
	{
		return self::orderBy('id', 'desc')->paginate($count);
	}

	public static function createUser($name, $email, $password)
	{
		if (is_null($user = self::create([
			'name' => $name,
			'email' => $email,
			'password' => $password
		]))) {
			return false;
		}
		return $user;
	}

	public static function getUserById($id)
	{
		if (!($user = self::find($id))) {
			return false;
		}
		return $user;
	}

	public static function deleteUserById($id)
	{
		if (self::find($id)->delete()) {
			return true;
		}
		return false;
	}

	public function roles()
	{
		return self::belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
	}

	public static function getUserWithRoleById($id)
	{
		if (!($user = self::with('roles')->find($id))) {
			return false;
		}
		return $user;
	}

}
