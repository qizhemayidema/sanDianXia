<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function uploadCommonImage(Request $request)
    {
        $path = $request->file('file','public')->store('common');

        return ['code'=>1,'path'=>$path];
    }
}
