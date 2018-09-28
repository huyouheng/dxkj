<?php
/**
 * Created by PhpStorm.
 * User: hyh
 * Date: 18-8-6
 * Time: 下午2:07
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class BaseModel extends Model
{
	protected $hidden = [
		'pivot'
	];

	public static function createData(array $data)
	{
		if (is_null($result = self::create($data))) {
			return false;
		}

		return $result;
	}

	public static function getData($count)
	{
		return self::orderBy('id', 'desc')->paginate($count);
	}

	public static function getDataById($id)
	{
		if (is_null($data = self::find($id))) {
			return false;
		}
		return $data;
	}

	public static function deleteById($id)
	{
		if (self::find($id)->delete()) {
			return true;
		}
		return false;
	}

}