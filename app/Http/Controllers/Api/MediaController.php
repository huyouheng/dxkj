<?php
/**
 * Created by PhpStorm.
 * User: hyh
 * Date: 18-7-31
 * Time: 下午3:17
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Admin\Util\MediaManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use ErrorException;

class MediaController extends Controller
{
	public function uploadFile(Request $request)
	{
		
		if (is_null($id = $request->get('id'))) {
			$id = str_random(10);
		}
		if (!$request->hasFile('files')){
			return $this->handleFailMsg(1, '上传文件不存在!');
		}
		$files = $request->file('files');

		try {
			$name = $files->getClientOriginalName();
			$ext = $files->getClientOriginalExtension();
			
			if ($ext == 'dxf') {
				$p_name = $request->get('buildName');

				$path = $files->storeAs('', $name, 'users');
				$filePath = public_path('/images/'.$path);
				if (!self::parseDxf($filePath,$p_name)) {
					return $this->handleFailMsg(1, '上传失败!');
				}
				return $this->handleSuccessMsg(0, '上传成功!', '/images/'.$path);

			} else {
				if ($path = $files->storeAs('', $name, 'users')) {
					return $this->handleSuccessMsg(0, '上传成功!', '/images/'.$path);
				}
			}
			
		} catch (\Exception $e) {
			info($e->getMessage());
			return $this->handleFailMsg(1, '上传失败!');
		}
	}

	public function getFile(Request $request)
	{
		$ids = $this->getCacheID();
		$path = [];
		foreach ($ids as $id) {
			$path[$id] = $this->getCacheById($id);
		}

		$collection = collect($path);
		if (is_null($perPage = $request->get('count'))) {
			$perPage = 30;
		}
		$currentPage = LengthAwarePaginator::resolveCurrentPage() - 1;
		$currentPageResults = $collection->slice($currentPage * $perPage, $perPage)->all();
		$paginate = new LengthAwarePaginator($currentPageResults, count($collection), $perPage);
		$paginate->setPath(url()->full());

		return $this->handleSuccessMsg(0, '', $paginate);
	}

	/**
	 * 获取geojson文件
	 */
	public function fetchFile(Request $request)
	{
		$tag = $request->get('name');

		if (is_null($uri = Cache::get($tag))) {
			return $this->handleFailMsg(1,'暂无数据!',null);
		}
		return $this->handleSuccessMsg(0,'获取成功!',$uri);
	}

	public function getCacheById($id)
	{
		return Cache::get('-IMG-' . $id);
	}

	private function getCacheID(): array
	{
		if (is_null($ids = Cache::get('-IDS'))) {
			$ids = '[]';
		}
		return json_decode($ids, true);
	}

	private function setCacheId($ids)
	{
		Cache::forever('-IDS', json_encode($ids));
	}

	private static function parseDxf($filePath,$p_name)
	{
		$geoName = time().'.geojson';
		$fileName =  pathinfo($filePath)['filename'];

		$str = file_get_contents($filePath);
		$tmpFile = str_replace($fileName,'tmp',$filePath);
		
		try{
			$result = iconv('UTF-8','GBK',$str);
		} catch (ErrorException  $e){
			$result = iconv('GBK','GBK',$str);
		}
		
		$newPath = public_path('images/'.$geoName);
		if (!$result = file_put_contents($tmpFile,$result)) {
			return false;
		}

		if (PHP_OS=='WINNT'){
			$path = public_path('images');

			$batContent = 'C:\OSGeo4W64\bin\ogr2ogr -f geojson '.$newPath .' '.$tmpFile;
			$_batContent= str_replace('/','\\',$batContent);
			file_put_contents($path.'/p.bat',str_replace('\\\\','\\',$_batContent));
			
			$cmd = 'cd '.$path.'&& p.bat';
			exec($cmd,$result);
			
			info($result);
		} else {
			$cmd = 'ogr2ogr -f geojson '.$newPath .' '.$tmpFile;
			$result = shell_exec($cmd);
		}
		Cache::forever($p_name,'/images/'.$geoName);
		// unlink($tmpFile);
		return true;
	}

}