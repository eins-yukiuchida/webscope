@extends('layouts.app')

@section('content')
<?php

use Illuminate\Support\Facades\DB;

$items = DB::table('price')->get();
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">販売価格設定</div>
                <br>
                <div class="panel-body">
                    <table class="table table-striped" style="border: white 2px solid;width:100%;">
                        <tr>
                            <th>販売価格設定</th>
                            <th>編集</th>

                        </tr>
                        @foreach ($items as $item)
                        <tr>
                            <td style="width:20%;">×<?php
                                                    echo $item->price;   // 各データの名前を表示
                                                    ?>倍</td>
                            <td style="width:10%;"> <a href="/price/edit" 　style="font-size: 80%; padding: 10px 20px;border: none;color: white;background: #666; border-radius: 100px;"> 編集</a></td>
                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection