@extends('layouts.app')

@section('content')
<?php

use Illuminate\Support\Facades\DB;

$items = DB::table('seller')->get();
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">除外オークションID</div>
                <br>
                <p>
                    <a href="/seller/add" style="color: white;border: none;background: #3490dc;padding: 10px 20px;margin-right: 20px;border-radius: 100px;">新規追加登録</a>
                </p>
                <div class="panel-body">
                    <table class="table table-striped" style="border: white 2px solid;　width:100%;">
                        <tr>
                            <th>登録済みの除外オークションID</th>
                            <th>編集</th>
                            <th>削除</th>
                        </tr>
                        @foreach ($items as $item)
                        <tr>
                            <td style="width:60%;"><?php
                                                    echo $item->yahoo_id;   // 各データの名前を表示
                                                    ?></td>
                            <td style="width:20%;"> <a href="/seller/edit/{{$item->id}}" 　style="font-size: 80%; padding: 10px 20px;border: none;color: white;background: #666; border-radius: 100px;"> 編集</a></td>
                            <td style="width:20%;"> <a href="/seller/delete/{{$item->id}}" 　style="font-size: 80%;padding: 10px 20px;border: none;color: white;;background: #ff534e; border-radius: 100px;"> 削除</a></td>
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