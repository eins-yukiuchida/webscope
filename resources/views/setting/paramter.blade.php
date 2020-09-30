@extends('layouts.app')

@section('content')
<?php

use Illuminate\Support\Facades\DB;

$items = DB::table('setting')->get();
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">
                    定型パラメータ
                </div>
                <br>
                <p>
                    <a href="/setting/edit" style="color: white;border: none;background: #3490dc;padding: 10px 20px;margin-right: 20px;border-radius: 100px;">編集</a>
                </p>
                <div class="panel-body">
                    <table class="table table-striped" style="border: white 2px solid;">
                        <tr>
                            <th>項目名</th>
                            <th>説明</th>
                            <th>値</th>
                        </tr>
                        <tr>
                            <td style="width:100px;">external_product_id_type</td>
                            <td style="width:200px;">商品コードのタイプ</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->external_product_id_type;   // 各データの名前を表示
                                                        }
                                                        ?></td>
                        </tr>
                        <tr>
                            <td style="width:100px;">feed_product_type</td>
                            <td style="width:200px;">商品タイプ</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->feed_product_type;   // 各データの名前を表示
                                                        }
                                                        ?></td>
                        </tr>
                        <tr>
                            <td style="width:100px;">part_number</td>
                            <td style="width:200px;">メーカー型番</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->part_number;   // 各データの名前を表示
                                                        }
                                                        ?></td>
                        </tr>
                        <tr>
                            <td style="width:100px;">model</td>
                            <td style="width:200px;">型番</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->model;   // 各データの名前を表示
                                                        }
                                                        ?></td>
                        </tr>
                        <tr>
                            <td style="width:100px;">quantity</td>
                            <td style="width:200px;">数量</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->quantity;   // 各データの名前を表示
                                                        }
                                                        ?></td>
                        </tr>
                        <tr>
                            <td style="width:100px;">recommended_browse_nodes</td>
                            <td style="width:200px;">推奨ブラウズノード番号</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->recommended_browse_nodes;   // 各データの名前を表示
                                                        }
                                                        ?></td>


                        </tr>
                        <tr>
                            <td style="width:100px;">fulfillment_latency</td>
                            <td style="width:200px;">出荷作業日数</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->fulfillment_latency;   // 各データの名前を表示
                                                        }
                                                        ?></td>
                        </tr>
                        <tr>
                            <td style="width:100px;">condition_type</td>
                            <td style="width:200px;">商品のコンディション</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->condition_type;   // 各データの名前を表示
                                                        }
                                                        ?></td>
                        </tr>
                        <tr>
                            <td style="width:100px;">condition_note</td>
                            <td style="width:200px;">商品のコンディション説明</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->condition_note;   // 各データの名前を表示
                                                        }
                                                        ?></td>
                        </tr>
                        <tr>
                            <td style="width:100px;">standard_price_points</td>
                            <td style="width:200px;">ポイント（販売価格に対するパーセントを記入）</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->standard_price_points;   // 各データの名前を表示
                                                        }
                                                        ?></td>
                        </tr>

                        <tr>
                            <td style="width:100px;">update_delete</td>
                            <td style="width:200px;">アップデート・削除</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->update_delete;   // 各データの名前を表示
                                                        }
                                                        ?></td>
                        </tr>
                        <tr>
                            <td style="width:100px;">is_adult_product</td>
                            <td style="width:200px;">アダルト商品</td>
                            <td style="width:300px;"><?php
                                                        foreach ($items as $item) {
                                                            echo $item->is_adult_product;   // 各データの名前を表示
                                                        }
                                                        ?></td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection