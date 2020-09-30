<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Hello2Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $items = DB::select('select * from keyword');
        return view('keyword', ['items' => $items]);
    }

    public function post(Request $request)
    {
        $items = DB::select('select * from keyword');
        return view('keyword', ['items' => $items]);
    }

    public function add(Request $request)
    {
        return view('setting.add2');
    }

    public function create(Request $request)
    {
        $param = [
            'keyword' => $request->keyword,
            'brand_name' => $request->brand_name,
            'manufacturer' => $request->manufacturer,
            'generic_keywords' => $request->generic_keywords,
        ];
        DB::insert('insert into setting (keyword,brand_name,manufacturer,generic_keywords) values(:keyword, :brand_name, :manufacturer,:generic_keywords)', $param);
        return redirect('paramter');
    }

    public function edit(Request $request)
    {
        $params = ['id' => $request->id];
        # select文でurlで指定したidデータを取得(今回はエラー処理していないのでidがなければコケる)

        $item = DB::select('select * from keyword where id = :id', $params);

        return view('setting.edit', ['form' => $item[0]]);
    }

    public function update(Request $request)
    {
        $params = [
            'id' => $request->id,
            'keyword' => $request->keyword,
            'brand_name' => $request->brand_name,
            'manufacturer' => $request->manufacturer,
            'generic_keywords' => $request->generic_keywords,
        ];
        DB::table('keyword')->where('id', 1)->update([
            'keyword' =>  $request->keyword,
        ]);

        return redirect('setting/keyword');
    }
}
