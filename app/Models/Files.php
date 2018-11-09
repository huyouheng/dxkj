<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Files extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'buildName', 'type', 'url', 'geo_url','file_name'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public static function isExistsDxf($buildName,$type)
    {
        if (!self::where([['buildName',$buildName],['type',$type]])->first()) {
            return false;
        }
        return true;
    }

    public static function replaceDxf($buildName,$path)
    {
        $dxf = self::where([['buildName',$buildName],['type','dxf']])->first();
        $dxf->url = $path;
        $dxf->save();
    }

    public static function store($buildName, $type, $path, $geo_url=null,$file_name=null)
    {
        $result = self::create([
            'buildName' => $buildName,
            'type' => $type,
            'url' => $path,
            'geo_url' => $geo_url,
            'file_name' => $file_name
        ]);
        if (!$result) {
            return false;
        }
        return true;
    }

    public static function fetch($buildName,$type)
    {
        return self::where([['buildName',$buildName],['type',$type]])->get();
    }

    public static function destroy($id)
    {
        if (!$r = self::find($id)) {
            return false;
        }
        $name = $r->buildName;
        Cache::forget($name);
        $r->delete();
        return $name;
    }
}
