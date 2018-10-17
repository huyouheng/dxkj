<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Admin\Util\MediaManager;
use App\Http\Controllers\Controller;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class FileManageController extends Controller
{
	private $breadcrumb = ['title' => "文件"];

	public function index(Request $request)
	{

	    $files = Files::paginate(20);

        return view('file.files', [
            'breadcrumb' => $this->breadcrumb,
            'files' => $files
        ]);
//		$path = $request->get('path', '/');
//		$view = $request->get('view', 'index');
//		$manager = new MediaManager($path);
//		$collection = collect($manager->ls());
//		$perPage = 30;
//		$currentPage = LengthAwarePaginator::resolveCurrentPage() - 1;
//		$currentPageResults = $collection->slice($currentPage * $perPage, $perPage)->all();
//		$paginate = new LengthAwarePaginator($currentPageResults, count($collection), $perPage);
//		$paginate->setPath(url()->full());
//
//		return view("file.$view", [
//			'list' => $manager->ls(),
//			'paginate' => $paginate,
//			'nav' => $manager->navigation(),
//			'url' => $manager->urls(),
//			'breadcrumb' => $this->breadcrumb
//		]);
	}

	public function download(Request $request)
	{
		$file = $request->get('file');

		$manager = new MediaManager($file);

		return $manager->download();
	}

	public function delete(Request $request)
	{
		$files = $request->get('files');

		$manager = new MediaManager();

		try {
			if ($manager->delete($files)) {
				return response()->json([
					'status' => true,
					'message' => trans('admin.delete_succeeded'),
				]);
			}
		} catch (\Exception $e) {
			return response()->json([
				'status' => true,
				'message' => $e->getMessage(),
			]);
		}
	}

	//新建文件夹
	public function newFolder(Request $request)
	{
		$dir = $request->get('dir');
		$name = $request->get('name');

		$manager = new MediaManager($dir);

		try {
			if ($manager->newFolder($name)) {
				return response()->json([
					'status' => true,
					'message' => trans('admin.new_folder_success'),
				]);
			}
		} catch (\Exception $e) {
			return response()->json([
				'status' => true,
				'message' => $e->getMessage(),
			]);
		}
	}

	//上传文件
	public function upload(Request $request)
	{
		$files = $request->file('files');
		$dir = $request->get('dir', '/');

		$manager = new MediaManager($dir);

		try {
			if ($manager->upload($files)) {
				admin_toastr(trans('admin.upload_succeeded'));
			}
		} catch (\Exception $e) {
			admin_toastr($e->getMessage(), 'error');
		}

		return back();
	}

	public function move(Request $request)
	{
		$path = $request->get('path');
		$new = $request->get('new');

		$manager = new MediaManager($path);
		try {
			if ($manager->move($new)) {
				return response()->json([
					'status' => true,
					'message' => trans('admin.move_succeeded'),
				]);
			}
		} catch (\Exception $e) {
			return response()->json([
				'status' => true,
				'message' => $e->getMessage(),
			]);
		}
	}
}