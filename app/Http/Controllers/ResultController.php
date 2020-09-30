<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $data = [
            'msg' => 'お名前を入力',
        ];
        return view('result', $data);
    }

    public function post(Request $request)
    {
        $msg = $request->msg;

        if (is_null($msg)) {
            return redirect('/');
        } else {
            $data = [
                'msg' => $msg,
            ];
            return view('result', $data);
        }
    }
}
