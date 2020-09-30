<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $items = DB::select('select * from price');
        return view('index', ['items' => $items]);
    }

    public function post(Request $request)
    {
        $items = DB::select('select * from price');
        return view('paramter', ['items' => $items]);
    }


    public function edit(Request $request)
    {
        $item = DB::select('select * from price where id = 1');

        return view('price.edit', ['form' => $item[0]]);
    }
    public function update(Request $request)
    {
        DB::table('price')->where('id', 1)->update([
            'price' =>  $request->price,
        ]);

        return redirect('/price');
    }
}
