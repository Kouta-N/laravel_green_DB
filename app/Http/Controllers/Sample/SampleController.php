<?php

namespace App\Http\Controllers\Sample;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SampleController extends Controller
{

    public function index()
    {
        $sample_msg = env('SAMPLE_MESSAGE');
        $sample_data = env('SAMPLE_DATA');
        $data = [
            'msg' => $sample_msg,
            'data' => explode(',',$sample_data),
        ];
        return view('hello.index', $data);
    }

    public function other(Request $request)
    {
        return redirect()->route('sample');
    }

    // public function index(Request $request)
    // {
    //     $data = [
    //         'msg'=>'SAMPLE CONTROLLER INDEX',
    //     ];
    //     return view('hello.index', $data);
    // }

    // public function other(Request $request)
    // {
    //     $data = [
    //         'msg'=>'SAMPLE CONTROLLER OTHER',
    //     ];
    //     return view('hello.index', $data);
    // }
}