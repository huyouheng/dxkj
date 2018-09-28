<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
	private $breadcrumb = ['title' => "用户"];

	public function index()
	{
		$users = User::getUsers(config('constant.PER_PAGE_COUNT'));

		return view('user.index')->with(['breadcrumb' => $this->breadcrumb, 'users' => $users]);
	}


	public function create()
	{
		return view('user.add')->with(['breadcrumb' => $this->breadcrumb]);
	}


	public function store(Request $request)
	{
		if (!($name = $this->hasParams($request, 'name'))) {
			admin_toastr('用户名不能为空', 'error');
			return back()->withInput();
		}
		if (!($email = $this->hasParams($request, 'email'))) {
			admin_toastr('邮箱不能为空', 'error');
			return back()->withInput();
		}
		if (!($password = $this->hasParams($request, 'password'))) {
			admin_toastr('密码不能为空', 'error');
			return back()->withInput();
		}
		if (!($passwordFore = $this->hasParams($request, 'password-fore'))) {
			admin_toastr('二次密码不能为空', 'error');
			return back()->withInput();
		}

		if ($password != $passwordFore) {
			admin_toastr('两次密码不相等', 'error');
			return back()->withInput();
		}

		$password = Hash::make($password);

		if (!($user = User::createUser($name, $email, $password))) {
			admin_toastr('创建失败', 'error');
			return back()->withInput();
		}
		admin_toastr('创建成功', 'success');
		return redirect(route('user'));

	}


	public function show($id)
	{
		//
	}


	public function edit($id)
	{
		if (!($user = User::getUserById($id))) {
			admin_toastr('用户不存在', 'error');
			return back();
		}
		return view('user.edit')->with(['breadcrumb' => $this->breadcrumb, 'user' => $user]);
	}

	public function update(Request $request, $id)
	{
		if (!($name = $this->hasParams($request, 'name'))) {
			admin_toastr('用户名不能为空', 'error');
			return back()->withInput();
		}
		if (!($email = $this->hasParams($request, 'email'))) {
			admin_toastr('邮箱不能为空', 'error');
			return back()->withInput();
		}
		if (!($password = $this->hasParams($request, 'password'))) {
			admin_toastr('密码不能为空', 'error');
			return back()->withInput();
		}
		if (!($passwordFore = $this->hasParams($request, 'password-fore'))) {
			admin_toastr('二次密码不能为空', 'error');
			return back()->withInput();
		}

		if ($password != $passwordFore) {
			admin_toastr('两次密码不相等', 'error');
			return back()->withInput();
		}
		$user = User::getUserById($id);

		if ($password != '@@@@@@?') {
			$user->password = Hash::make($password);
		}
		$user->name = $name;
		$user->email = $email;
		$user->save();

		admin_toastr('更新成功', 'success');
		return redirect(route('user'));
	}

	public function destroy($id)
	{
		if (!($user = User::deleteUserById($id))) {
			return response()->json(['code' => 1, 'msg' => '用户不存在!']);
		}

		return response()->json(['code' => 0, 'msg' => '删除成功!']);
	}

	public function addUserRole(Request $request, $id)
	{
		$user = User::getUserWithRoleById($id);
		return view('user.addRole')->with(['breadcrumb' => $this->breadcrumb, 'user' => $user]);
	}

	public function storeUserRole(Request $request, $id)
	{
		if (!($user = User::getUserById($id))){
			admin_toastr('参数错误', 'error');
			return back();
		}
		if (!($roles = $this->hasParams($request, 'roles'))) {
			DB::table('user_roles')->where('user_id','=', $id)->delete();
			admin_toastr('修改用户角色成功','success');
			return redirect(route('user'));
		}

		$data = array();
		foreach ($roles as $role){
			$data [] = ['user_id' => $id, 'role_id' => $role];
		}

		DB::table('user_roles')->where('user_id','=', $id)->delete();
		DB::table('user_roles')->insert($data);
		admin_toastr('修改用户角色成功','success');
		return redirect(route('user'));
	}

}
