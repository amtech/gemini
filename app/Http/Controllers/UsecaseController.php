<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sheet;
use App\Usecase;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class UsecaseController extends Controller
{
    public function find(Request $request, $id) {
        $usecase=Usecase::find($id);
        $first_setp=$usecase->setps()->first();

        $usecase_id=Cookie::forever('usecase_id', $usecase->id, $path = null, $domain = null, $secure = false, $httpOnly = false);
        $usecase_setp_index=Cookie::forever('usecase_setp_index', 1, $path = null, $domain = null, $secure = false, $httpOnly = false);

        $response=view('usecase',
              [
                'first_setp_id'=>$first_setp->page_id,
                'usecase_id'=>$usecase->id,
                'usecase_setp_index'=>1
              ]
        );
        $response=(string)$response;

        if (Cookie::get('static')=='true') {
            $path=$request->getPathInfo();
            $path=substr($path, 1);
            Storage::disk('public_path')->put($path, $response);
        }
        return $response;
    }

}
