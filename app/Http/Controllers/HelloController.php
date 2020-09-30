<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HelloController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $items = DB::select('select * from setting');
        return view('paramter', ['items' => $items]);
    }

    public function post(Request $request)
    {
        $items = DB::select('select * from setting');
        return view('paramter', ['items' => $items]);
    }

    public function add(Request $request)
    {
        return view('hello.add');
    }

    public function create(Request $request)
    {
        $param = [
            'feed_product_type' =>  $request->feed_product_type,
            'quantity' =>  $request->quantity,
            'recommended_browse_nodes' =>  $request->recommended_browse_nodes,
            'fulfillment_latency' =>  $request->fulfillment_latency,
            'condition_type' =>  $request->condition_type,
            'condition_note' =>  $request->condition_note,
            'standard_price_points' =>  $request->standard_price_points,
        ];
        DB::insert('insert into setting (feed_product_type,quantity,recommended_browse_nodes,fulfillment_latency,condition_type,condition_note,standard_price_points) values(:feed_product_type, :quantity, :recommended_browse_nodes,:fulfillment_latency,:condition_type,:condition_note,:standard_price_points)', $param);
        return redirect('paramter');
    }


    public function edit(Request $request)
    {
        $item = DB::select('select * from setting where id = 1');

        return view('setting.edit', ['form' => $item[0]]);
    }
    public function update(Request $request)
    {
        DB::table('setting')->where('id', 1)->update([
            'feed_product_type' =>  $request->feed_product_type,
            'quantity' =>  $request->quantity,
            'recommended_browse_nodes' =>  $request->recommended_browse_nodes,
            'fulfillment_latency' =>  $request->fulfillment_latency,
            'condition_type' =>  $request->condition_type,
            'condition_note' =>  $request->condition_note,
            'standard_price_points' =>  $request->standard_price_points,
            'part_number' =>  $request->part_number,
            'external_product_id_type' =>  $request->external_product_id_type,
            'model' =>  $request->model,
            'update_delete' =>  $request->update_delete,
            'is_adult_product' =>  $request->is_adult_product,
        ]);

        return redirect('setting/paramter');
    }
}
