<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerController extends Controller
{
	private $perPageCount = 20;
	private $breadcrumb = ['title' => "权限"];

	public function index(Request $request)
	{
		$pers = Permission::getPermissions(config('constant.PER_PAGE_COUNT'));
		if ($request->get('is_ajax')) {
			return $this->handleSuccessMsg(0, '', $pers);
		}
		return view('permissions.index')->with(['breadcrumb' => $this->breadcrumb, 'permissions' => $pers]);
	}


	public function create()
	{
		$display_name = str_random(10);
		return view('permissions.add')->with(['breadcrumb' => $this->breadcrumb, 'display_name' => $display_name]);
	}


	public function store(Request $request)
	{
		if (!($name = $this->hasParams($request, 'name'))) {
			admin_toastr('角色名不能为空', 'error');
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
			admin_toastr('添加角色失败', 'error');
			return back()->withInput();
		}
		info(1);
		admin_toastr('添加角色成功', 'success');
		return redirect(route('role'));
	}


	public function show($id)
	{
		//
	}


	public function edit($id)
	{
		if (!($permission = Permission::getDataById($id))) {
			admin_toastr('权限不存在', 'info');
			return back();
		}
		return view('permissions.edit')->with(['permission' => $permission, 'breadcrumb' => $this->breadcrumb]);
	}


	public function update(Request $request, $id)
	{

		if (!($per = Permission::getDataById($id))) {
			admin_toastr('权限不存在', 'info');
			return back();
		}
		$per->update($request->all());
		admin_toastr('权限不存在', 'success');
		return redirect(route('permission'));
	}


	public function destroy($id)
	{
		if (!($user = Permission::deleteById($id))) {
			return response()->json(['code' => 1, 'msg' => '角色不存在!']);
		}

		return response()->json(['code' => 0, 'msg' => '删除成功!']);
	}
}
