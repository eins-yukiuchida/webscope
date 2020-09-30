<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function add(Request $request)
    {
        return view('keyword.add');
    }

    public function create(Request $request)
    {
        $param = [
            'keyword' =>  $request->keyword,
            'brand_name' =>  $request->brand_name,
            'manufacturer' =>  $request->manufacturer,
            'generic_keywords' =>  $request->generic_keywords
        ];
        DB::insert('insert into keyword (keyword,brand_name,manufacturer,generic_keywords) values(:keyword, :brand_name, :manufacturer,:generic_keywords)', $param);
        return redirect('/keyword');
    }


    public function edit(Request $request)
    {
        $params = ['id' => $request->id];
        # select文でurlで指定したidデータを取得(今回はエラー処理していないのでidがなければコケる)
        $item = DB::select('select * from keyword where id = :id', $params);
        return view('keyword.edit', ['form' => $item[0]]);
    }

    public function update(Request $request)
    {
        $params = [
            'id' => $request->id,
            'keyword' => $request->keyword
        ];
        DB::update('update keyword set keyword = :keyword where id = :id', $params);
        return redirect('/keyword');
    }

    public function deleteEdit(Request $request)
    {
        $params = ['id' => $request->id];
        # select文でurlで指定したidデータを取得(今回はエラー処理していないのでidがなければコケる)
        $item = DB::select('select * from keyword where id = :id', $params);
        return view('keyword.delete', ['form' => $item[0]]);
    }

    public function delete(Request $request)
    {
        $params = ['id' => $request->id];

        DB::table('keyword')->where('id', $params)->delete();
        return redirect('/keyword');
    }
}
