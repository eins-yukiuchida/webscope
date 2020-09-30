<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function add(Request $request)
    {
        return view('seller.add');
    }

    public function create(Request $request)
    {
        $param = [
            'yahoo_id' =>  $request->yahoo_id
        ];
        DB::insert('insert into seller (yahoo_id) values(:yahoo_id)', $param);
        return redirect('/seller');
    }


    public function edit(Request $request)
    {
        $params = ['id' => $request->id];
        # select文でurlで指定したidデータを取得(今回はエラー処理していないのでidがなければコケる)
        $item = DB::select('select * from seller where id = :id', $params);
        return view('seller.edit', ['form' => $item[0]]);
    }

    public function update(Request $request)
    {
        $params = [
            'id' => $request->id,
            'yahoo_id' => $request->yahoo_id
        ];
        DB::update('update seller set yahoo_id = :yahoo_id where id = :id', $params);
        return redirect('/seller');
    }

    public function deleteEdit(Request $request)
    {
        $params = ['id' => $request->id];
        # select文でurlで指定したidデータを取得(今回はエラー処理していないのでidがなければコケる)
        $item = DB::select('select * from seller where id = :id', $params);
        return view('seller.delete', ['form' => $item[0]]);
    }

    public function delete(Request $request)
    {
        $params = ['id' => $request->id];

        DB::table('seller')->where('id', $params)->delete();
        return redirect('/seller');
    }
}
