<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public $fail_code = 1;
	public $success_code = 0;


	public function hasParams($request,$params)
	{
		if (is_null($result = $request->get($params))){
			return false;
		}
		return $result;
	}

	public function handleSuccessMsg($code, $msg = '', $data = null)
	{
		return json_encode(['code'=>$code,'msg'=>$msg,'data'=>$data]);
	}

	public function handleFailMsg($code, $msg = '',$data = [])
	{
		return json_encode(['code'=>$code,'msg'=>$msg, 'data'=>$data]);
	}

}
