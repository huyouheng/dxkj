<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

	private $breadcrumb = ['title' => "角色"];

	public function index(Request $request)
	{
		$roles = Role::getData(config('constant.PER_PAGE_COUNT'));
		if ($request->get('is_ajax')) {
			return $this->handleSuccessMsg(0, '', $roles);
		}

		return view('roles.index')->with(['roles' => $roles, 'breadcrumb' => $this->breadcrumb]);

	}


	public function create()
	{
		$display_name = str_random(10);
		return view('roles.add')->with(['breadcrumb' => $this->breadcrumb, 'display_name' => $display_name]);
	}


	public function store(Request $request)
	{
		if (!($name = $this->hasParams($request, 'name'))) {
			admin_toastr('权限名不能为空', 'error');
			return back()->withInput();
		}
		if (!($display_name = $this->hasParams($request, 'display_name'))) {
			admin_toastr('标识名不能为空', 'error');
			return back()->withInput();
		}
		if (!($description = $this->hasParams($request, 'description'))) {
			admin_toastr('描述不能为空', 'error');
			return back()->withInput();
		}

		if (!Role::createData(['name' => $name, 'display_name' => $display_name, 'description' => $description])) {
			admin_toastr('添加权限失败', 'error');
			return back()->withInput();
		}

		admin_toastr('添加权限成功', 'success');
		return redirect(route('role'));

	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		if (!($roles = Role::getDataById($id))) {
			admin_toastr('角色不存在', 'info');
			return back();
		}
		return view('roles.edit')->with(['roles' => $roles, 'breadcrumb' => $this->breadcrumb]);
	}


	public function update(Request $request, $id)
	{
		if (!($role = Role::getDataById($id))) {
			admin_toastr('角色不存在', 'info');
			return back();
		}
		$role->update($request->all());
		admin_toastr('角色不存在', 'success');
		return redirect(route('role'));
	}


	public function destroy($id)
	{
		if (!($user = Role::deleteById($id))) {
			return response()->json(['code' => 1, 'msg' => '角色不存在!']);
		}

		return response()->json(['code' => 0, 'msg' => '删除成功!']);
	}

	public function addRolePer($id)
	{
		$role = Role::getRoleWithPerById($id);
		return view('roles.addPer')->with(['breadcrumb' => $this->breadcrumb, 'role' => $role]);
	}

	public function storeRolePer(Request $request, $id)
	{
		if (!($user = Role::getDataById($id))){
			admin_toastr('参数错误', 'error');
			return back();
		}
		if (!($perms = $this->hasParams($request, 'permissions'))) {
			DB::table('role_permissions')->where('role_id','=', $id)->delete();
			admin_toastr('修改角色权限成功','success');
			return redirect(route('role'));
		}

		$data = array();
		foreach ($perms as $p){
			$data [] = ['role_id' => $id, 'permission_id' => $p];
		}

		DB::table('role_permissions')->where('role_id','=', $id)->delete();
		DB::table('role_permissions')->insert($data);
		admin_toastr('修改角色权限成功','success');
		return redirect(route('role'));
	}
}
