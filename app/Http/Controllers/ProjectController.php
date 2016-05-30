<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function find(Request $request, $id) {
        $project=Project::with('usecases')->find($id);

        $response=view('project', ['project' => $project]);
        $response=(string)$response;

        if (Cookie::get('static')=='true') {
            $path=$request->getPathInfo();
            $path=substr($path, 1);
            Storage::disk('public_path')->put($path.'.html', $response);
        }
        return $response;
    }

}
