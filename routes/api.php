<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([], function(\Illuminate\Routing\Router $route){
    $route->post('uploadFile', 'Api\MediaController@uploadFile');
    $route->get('fetchFile', 'Api\MediaController@fetchFile');
    $route->delete('deleteFile','Api\MediaController@deleteFile');
});

/**
 *  addres      method          params
 * 
 * uploadFile    post       buildName,files
 * fetchFile     get        (buildName,type)获取图片或dxf,type=(img,dxf)。|| (name)获取geojson
 * deleteFile   delete             id
 * 
 */