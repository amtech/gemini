<?php

namespace App\Http\Controllers;

use App\Usecase;
use Illuminate\Http\Request;
use App\Page;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function find(Request $request, $id) {
        $page=Page::find($id);

        //是否指定用例
        $usecase_id=Cookie::get('usecase_id');
        $usecase_setp_index=Cookie::get('usecase_setp_index', 1);
        if ($usecase_id) {
            $usecase=Usecase::with('setps')->find($usecase_id);
        }

        $response=view('page', [
            'page'=>$page,
            'usecase'=>isset($usecase)?$usecase:null,
            'usecase_setp_index'=>$usecase_setp_index
        ]);
        $response=(string)$response;

        if (Cookie::get('static')=='true') {
            $path=$request->getPathInfo();
            $path=substr($path, 1);
            Storage::disk('public_path')->put($path, $response);
        }
        return $response;
    }

}
