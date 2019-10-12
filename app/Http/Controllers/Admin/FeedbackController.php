<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FeedbackController extends BaseController
{
    public function index()
    {
        $res = DB::table('feedback')->orderBy('id','desc')->paginate(15);

        return view('admin.feedback.index',compact('res'));
    }
}
