<?php

namespace App\Models;


class Role extends BaseModel
{
	protected $table = 'roles';

	protected $fillable = [
		'name', 'description', 'display_name'
	];


	public function permissions()
	{
		return $this->belongsToMany(Permission::class,'role_permissions','role_id','permission_id');
	}


	public static function getRoleWithPerById($id)
	{
		return self::with('permissions')->find($id);
	}
}
