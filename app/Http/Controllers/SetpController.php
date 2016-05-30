<?php

namespace App\Http\Controllers;

use App\Setp;
use Illuminate\Support\Facades\Cache;

class SetpController extends Controller
{
    public function find($id) {
        $setp=Setp::find($id)->with('nextsetp')->with('presetp');

        $setpOfUsecase=Setp::where('usecase_id', '=', $setp->usecase_id)->orderBy('order')->get();
        for ($i=0;$i<$setpOfUsecase->count();$i++) {
            $tmp=$setpOfUsecase.get($i);
            if ($setp->id == $tmp->id) {
                $index=$i;
                break;
                /*if ($i>0) {
                    $presetp=$setpOfUsecase.get($i-1);
                }
                if ($i<$setpOfUsecase->count()-1) {
                    $nextsetp=$setpOfUsecase.get($i+1);
                }*/
            }
        }

        return view('setp', [
            'setp'=>$setp,
            'setpOfUsecase'=>$setpOfUsecase,
            'index'=>$index
        ]);
    }

}
