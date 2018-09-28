<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{


	public function login(Request $request)
	{
		if (!($username = $this->hasParams($request, 'username'))) {
			return $this->handleFailMsg($this->fail_code, '用户名不能为空');
		}

		if (!($password = $this->hasParams($request, 'password'))) {
			return $this->handleFailMsg($this->fail_code, '用户密码不能为空');
		}

		if (!($user = User::hasUser($username))) {
			return $this->handleFailMsg($this->fail_code, '用户名不存在');
		}


		if (!Hash::check($password, $user->password)) {
			return $this->handleFailMsg($this->fail_code, '密码错误');
		}

		Auth::login($user);
		$this->changeLoginTime($user);
		$userRoles = $user->roles;
		$roles = [];
		foreach ($userRoles as $role) {
			$roles [] = $role->name;
		}
		$user['role'] = $roles;
		unset($user['roles']);
		return $this->handleSuccessMsg($this->success_code, '登录成功', $user);
	}

	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		return $this->handleSuccessMsg($this->success_code, '登出成功');
	}

    public function checkLogin()
    {
        if (Auth::user()) {
            return $this->handleSuccessMsg($this->success_code, '', true);
        }
        return $this->handleFailMsg(1,'',false);
	}

	private function changeLoginTime($user)
	{
		$user->last_login = date('Y-m-d H:i:s');
		$user->save();
	}


}
