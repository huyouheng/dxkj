<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Util\UserPerUtil;
use App\Models\Permission;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use ErrorException;
use Cache;

class TestController extends Controller
{
	//

	private function isPopSmartPath()
	{
		$str = 'http://www.popsmart.cn/login?s=%2FPopSmart';
		$pathUrl = parse_url($str);


		URL::previous();
		if (isset($pathUrl['path']) && $pathUrl['path'] == '/PopSmart') {
			echo " --a	";
		}

	}

	public function index()
	{

		// echo date('Y-m-d H:i:s');
		
	  	// return mb_convert_encoding($str,'GBK');

//        return User::createUser('admin','admin',Hash::make('admin'));

		$this->isPopSmartPath();

		 return view('test');

//		$roles = [3, 4, 5, 6];

//		$user = User::find(1);
//		$role = Role::find(3);

//		$roles = Role::all();


//		$db = DB::table('user_roles')->where('user_id','=',9)->get();

//		return $db;
//		return $user->roles;


//		$p = Permission::create(
//
//			[
//				'name' => str_random(2),
//				'display_name' => str_random(10),
//				'description' => '能够看订单页权限'
//			]
//		);
//
//		return $p;

//		$user = User::find(1);
//
//		$p = UserPerUtil::getPermission($user);
//		return $p;

//		$a = '[]';

		// return json_decode($a, true);

    
//    return env('APP_NAME');

	  

	}

	private function parseDxf($filePath)
	{
		$fileName =  pathinfo($filePath)['filename'];

		$str = file_get_contents($filePath);
		$tmpFile = public_path('tmp.dxf');
		try{
			$result = iconv('GBK','GBK',$str);
		} catch (ErrorException  $e){
			$result = iconv('UTF-8','GBK',$str);
		}
		
		$newPath = public_path($fileName.'.geojson');

		if (!$result = file_put_contents($tmpFile,$result)) {
			return false;
		}

		$cmd = 'ogr2ogr -f geojson '.$newPath .' '.$tmpFile;

		$result = shell_exec($cmd);
		unlink($tmpFile);
		return true;
	}
}
