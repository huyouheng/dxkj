<?php

namespace App\Models;


class Permission extends BaseModel
{
    protected $table = 'permissions';

    protected $fillable = [
		'name', 'description', 'display_name'
	];


	public static function getPermissions($count)
	{
		return self::orderBy('id', 'desc')->paginate($count);
    }


}
