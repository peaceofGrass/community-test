<?php

namespace App\Http\Controllers;

class NoticeController extends Controller
{
    public function index() {
        $notices = \Auth::user()->notices;
        return view('notice/index', compact('notices'));
    }
}
