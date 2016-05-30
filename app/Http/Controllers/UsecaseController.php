<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sheet;
use App\Usecase;
use Illuminate\Support\Facades\Cookie;

class UsecaseController extends Controller
{
    public function find(Request $request, $id) {
        $usecase=Usecase::find($id);
        $first_setp=$usecase->setps()->first();

        $usecase_id=Cookie::forever('usecase_id', $usecase->id, $path = null, $domain = null, $secure = false, $httpOnly = false);
        $usecase_setp_index=Cookie::forever('usecase_setp_index', 1, $path = null, $domain = null, $secure = false, $httpOnly = false);


        return redirect('page/'.$first_setp->page_id)->withCookies([$usecase_id, $usecase_setp_index]);
    }

}
