@extends('layouts.app')

@section('content')
<?php

use Illuminate\Support\Facades\DB;

$items = DB::table('setting')->get();
$users = DB::table('users')->get();
$keywords = DB::table('keyword')->get();
$sellers = DB::table('seller')->get();
$prices = DB::table('price')->get();

date_default_timezone_set('Asia/Tokyo');

$date = date('Ymd');

use Goutte\Client;

use function PHPSTORM_META\elementType;

// 指定されたページへアクセスする
$url = $msg;
$client = new Client();
$crawler = $client->request('GET', $url);

// 商品名
$productName = $crawler->filter('.ProductTitle__text')->text();

// 個数
$ProductStatus = $crawler->filter('.ProductDetail__description')->first()->text();
$ProductStatus_A = str_replace("：", "", $ProductStatus);

// オークションID
$ProductID = $crawler->filter('.ProductDetail__description')->last()->text();
$ProductID_A = str_replace("：", "", $ProductID);

//乱数を生成する
$min = 100000000000;
$max = 999999999999;
$ram = mt_rand($min, $max);

?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <?php
                    $brand_name = "";
                    $manufacturer =  "";
                    $generic_keywords = "";
                    foreach ($keywords as $item) {
                        if (
                            strpos($productName, $item->keyword) !==
                            false
                        ) {
                            $brand_name = $item->brand_name;
                            $manufacturer =  $item->manufacturer;
                            $generic_keywords = $item->generic_keywords;
                        }
                    }
                    ?>

                    <p>
                        <a href="/main" style="color: white;border: none;background: #3490dc;padding: 10px 20px;margin-right: 20px;border-radius: 100px;">URL再入力</a>
                        <a id="download" href="#" download="{{$date}}_{{$ram}}" onclick="handleDownload()" style="color: white;border: none;background: #21c567;padding: 10px 20px;border-radius: 100px;"> CSVダウンロード</a>
                    </p>

                    <table border="1px" width="100%" style="border: rgb(204, 204, 204);" id="resultTBL">
                        <tbody style="border: rgb(204, 204, 204);">
                            <tr>
                                <th>
                                    商品名
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    echo ($productName  . PHP_EOL);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    現在価格
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    $currentPrice = $crawler->each(function ($element) {
                                        if (count($element->filter('.Price--current'))) {
                                            $currentPrice = $element->filter('.Price--current')->filter('.Price__value')->text();
                                            echo ($currentPrice . PHP_EOL);
                                        } else {
                                            echo "0円";
                                        }
                                    }); ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    即決価格
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    $buynowPrice = $crawler->each(function ($element) {
                                        if (count($element->filter('.Price--buynow'))) {
                                            $buynowPrice = $element->filter('.Price--buynow')->filter('.Price__value')->text();
                                            echo ($buynowPrice  . PHP_EOL);
                                        } else {
                                            echo "0円";
                                        }
                                    });
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    オークションID
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    echo ($ProductID_A  . PHP_EOL);
                                    ?>
                                    <?php
                                    foreach ($sellers as $item) {
                                        if (
                                            strpos($ProductID_A, $item->yahoo_id) !==
                                            false
                                        ) {
                                            echo "<p style='color:red;'>除外オークションIDに登録されています。</p>";
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    $currentPrice = $crawler->each(function ($element) {

                        if (count($element->filter('.Price--current'))) {
                            $currentPrice = $element->filter('.Price--current')->filter('.Price__value')->text();
                            $currentPrice_A = str_replace("円（税 0 円）", "", $currentPrice);
                        }
                    });
                    // 即決価格

                    $buynowPrice = $crawler->each(function ($element) {

                        if (count($element->filter('.Price--buynow'))) {
                            $buynowPrice = $element->filter('.Price--buynow')->filter('.Price__value')->text();
                            $buynowPrice_A = str_replace("円（税 0 円）", "", $buynowPrice);
                        }
                    });

                    ?>


                    <?php
                    $currentPrice = $crawler->filter('.Price--current')->filter('.Price__value');

                    if ($currentPrice->count() == 0) {
                        echo "";
                    } else {
                        $currentPrice  = $crawler->filter('.Price--current')->filter('.Price__value')->text();
                        $currentPrice_A = str_replace("円（税 0 円）", "", $currentPrice);
                    }

                    $buynowPrice = $crawler->filter('.Price--buynow')->filter('.Price__value');

                    if ($buynowPrice->count() == 0) {
                        echo "";
                    } else {
                        $buynowPrice = $crawler->filter('.Price--buynow')->filter('.Price__value')->text();
                        $buynowPrice_A = str_replace("円（税 0 円）", "", $buynowPrice);
                    }

                    ?>



                    <div id="contents">
                        <div id="main">
                            <table id="TBL" border="1" cellpadding="10">
                                <tbody style="border: #ccc;">
                                    <!-- 1行目 -->
                                    <tr>
                                        <th>A</th>
                                        <th>B</th>
                                        <th>C</th>
                                        <th>D</th>
                                        <th>E</th>
                                        <th>F</th>
                                        <th>G</th>
                                        <th>H</th>
                                        <th>I</th>
                                        <th>J</th>
                                        <th>K</th>
                                        <th>L</th>
                                        <th>M</th>
                                        <th>N</th>
                                        <th>O</th>
                                        <th>P</th>
                                        <th>Q</th>
                                        <th>R</th>
                                        <th>S</th>
                                        <th>T</th>
                                        <th>U</th>
                                        <th>V</th>
                                        <th>W</th>
                                        <th>X</th>
                                        <th>Y</th>
                                        <th>Z</th>
                                        <th>AA</th>
                                        <th>AB</th>
                                        <th>AC</th>
                                        <th>AD</th>
                                        <th>AE</th>
                                        <th>AF</th>
                                        <th>AG</th>
                                        <th>AH</th>
                                        <th>AI</th>
                                        <th>AJ</th>
                                        <th>AK</th>
                                        <th>AL</th>
                                        <th>AM</th>
                                        <th>AN</th>
                                        <th>AO</th>
                                        <th>AP</th>
                                        <th>AQ</th>
                                        <th>AR</th>
                                        <th>AS</th>
                                        <th>AT</th>
                                        <th>AU</th>
                                        <th>AV</th>
                                        <th>AW</th>
                                        <th>AX</th>
                                        <th>AY</th>
                                        <th>AZ</th>
                                        <th>BA</th>
                                        <th>BB</th>
                                        <th>BC</th>
                                        <th>BD</th>
                                        <th>BE</th>
                                        <th>BF</th>
                                        <th>BG</th>
                                        <th>BH</th>
                                        <th>BI</th>
                                        <th>BJ</th>
                                        <th>BK</th>
                                        <th>BL</th>
                                        <th>BM</th>
                                        <th>BN</th>
                                        <th>BO</th>
                                        <th>BP</th>
                                        <th>BQ</th>
                                        <th>BR</th>
                                        <th>BS</th>
                                        <th>BT</th>
                                        <th>BU</th>
                                        <th>BV</th>
                                        <th>BW</th>
                                        <th>BX</th>
                                        <th>BY</th>
                                        <th>BZ</th>
                                        <th>CA</th>
                                        <th>CB</th>
                                        <th>CC</th>
                                        <th>CD</th>
                                        <th>CE</th>
                                        <th>CF</th>
                                        <th>CG</th>
                                        <th>CH</th>
                                        <th>CI</th>
                                        <th>CJ</th>
                                        <th>CK</th>
                                        <th>CL</th>
                                        <th>CM</th>
                                        <th>CN</th>
                                        <th>CO</th>
                                        <th>CP</th>
                                        <th>CQ</th>
                                        <th>CR</th>
                                        <th>CS</th>
                                        <th>CT</th>
                                        <th>CU</th>
                                        <th>CV</th>
                                        <th>CW</th>
                                        <th>CX</th>
                                        <th>CY</th>
                                        <th>CZ</th>
                                        <th>DA</th>
                                        <th>DB</th>
                                        <th>DC</th>
                                        <th>DD</th>
                                        <th>DE</th>
                                        <th>DF</th>
                                        <th>DG</th>
                                        <th>DH</th>
                                        <th>DI</th>
                                        <th>DJ</th>
                                        <th>DK</th>
                                        <th>DL</th>
                                        <th>DM</th>
                                        <th>DN</th>
                                        <th>DO</th>
                                        <th>DP</th>
                                        <th>DQ</th>
                                        <th>DR</th>
                                        <th>DS</th>
                                        <th>DT</th>
                                        <th>DU</th>
                                        <th>DV</th>
                                        <th>DW</th>
                                        <th>DX</th>
                                        <th>DY</th>
                                        <th>DZ</th>
                                        <th>EA</th>
                                        <th>EB</th>
                                        <th>EC</th>
                                        <th>ED</th>
                                        <th>EE</th>
                                        <th>EF</th>
                                        <th>EG</th>
                                    </tr>
                                    <!-- 2行目 -->
                                    <tr>
                                        <td>
                                            <div class="table-cell">TemplateType=fptcustom</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">Version=2020.0001</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">上3行は Amazon.com 記入用です。上3行は変更または削除しないでください。</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell">出品情報-商品をサイト上で販売可能にする際に必要な項目</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell">寸法-商品のサイズや重量を入力する項目</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品検索情報-サーチ上で商品を検索されやすくするために必要な項目</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell">画像-商品画像を表示させるために必要な項目。詳しくは画像説明タブを参照</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell">出荷関連情報-フルフィルメント by Amazon (FBA) の利用、あるいは自社出荷の注文に関する出荷関連情報を、この項目に記入してください。FBA を利用する場合には必須の項目。</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell">バリエーション-商品の色・サイズなどのバリエーションを作成する際に必須の項目</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>

                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell">コンプライアンス情報-商品を販売する国または地域の特定商取引に遵守するために利用される項目</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell">ProductTypeによって必須となる項目</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>

                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>

                                    </tr>
                                    <!-- 3行目 -->
                                    <tr>
                                        <td>
                                            <div class="table-cell">出品者SKU</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品名</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品コード(JANコード等) </div>
                                        </td>

                                        <td>
                                            <div class="table-cell">商品コードのタイプ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">ブランド名</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー名</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品タイプ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー型番</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品説明文</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">型番</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">アップデート・削除</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">在庫数</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">出荷作業日数</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の販売価格</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">ポイント</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品のコンディション</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品のコンディション説明</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の公開日</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">予約商品の販売開始日</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の入荷予定日</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">使用しない支払い方法</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">配送日時指定SKUリスト</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">セール価格</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">セール時ポイント</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">セール開始日</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">セール終了日</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">パッケージ商品数</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー希望価格</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">付属品総数</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">ギフト包装</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">ギフトメッセージ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">最大注文個数</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー製造中止</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">廃盤日</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">配送パターン</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">販売形態(並行輸入品)</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品タックスコード</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">発送重量</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">発送重量の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の重量</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の重量の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の高さ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の長さ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の幅</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品寸法の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の重量</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の重量の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の長さ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の長さの単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品説明の箇条書き1</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品説明の箇条書き2</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品説明の箇条書き3</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品説明の箇条書き4</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品説明の箇条書き5</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">推奨ブラウズノード</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">検索キーワード</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品メイン画像URL</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">カラーサンプル画像URL</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品サブ画像URL1</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品サブ画像URL2</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品サブ画像URL3</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品サブ画像URL4</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品サブ画像URL5</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品サブ画像URL6</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品サブ画像URL7</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品サブ画像URL8</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">フルフィルメントセンターID</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品パッケージの長さ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品パッケージの幅</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品パッケージの高さ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品パッケージの長さの単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品パッケージの重量</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品パッケージの重量の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">親子関係の指定</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">バリエーションテーマ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">親商品のSKU(商品管理番号)</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">親子関係のタイプ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">法規上の免責条項</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">安全性の注意点</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">製造国</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">原産国</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー推奨最少年齢</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー推奨最少年齢の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー推奨最高年齢</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー推奨最高年齢の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">対象性別</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー保証の説明</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">組み立て方法</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">要組み立て</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">組み立て時間</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">組み立て時間の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー推奨最少体重</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー推奨最少体重の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー推奨最大体重</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">メーカー推奨最大体重の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">推奨最低身長</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">推奨最低身長の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">推奨最高身長</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">推奨最高身長の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">折りたたみ時のサイズ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">素材タイプ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">お取り扱い上の注意1</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">お取り扱い上の注意2</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">お取り扱い上の注意3</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">特殊機能</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">サイズ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">サイズマップ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">カラー</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">カラーマップ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">アダルト商品</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">商品の個数(ピース数)</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">最大プレーヤー数</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">キャラクター</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">素材構成</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">スケール</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">レールのゲージ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">リモコンのタイプ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">サポートしている周波数帯域</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">エンジンタイプ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">推奨使用方法・場所</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">教育目的</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">コレクション名</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">トレーディングカードのタイプ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">トレーディングカードのジャンル</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">ハンドルの高さ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">ハンドルの高さの単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">座面（椅子）の幅</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">座面（椅子）の幅の単位</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">電池付属</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">電池の必要性</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">電池の説明</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">電池のタイプ</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">付属バッテリ個数</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">リチウム電池エネルギー含有量</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">リチウム電池重量</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">リチウム電池パッケージ仕様</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">is_expiration_dated_product</div>
                                        </td>
                                    </tr>
                                    <!-- 4行目 -->
                                    <tr>
                                        <td>
                                            <div class="table-cell">item_sku</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_name</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">external_product_id</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">external_product_id_type</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">brand_name</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">manufacturer</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">feed_product_type</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">part_number</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">product_description</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">model</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">update_delete</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">quantity</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">fulfillment_latency</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">standard_price</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">standard_price_points</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">condition_type</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">condition_note</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">product_site_launch_date</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">merchant_release_date</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">restock_date</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">optional_payment_type_exclusion</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">delivery_schedule_group_id</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">sale_price</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">sale_price_points</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">sale_from_date</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">sale_end_date</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_package_quantity</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">list_price</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">number_of_items</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">offering_can_be_giftwrapped</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">offering_can_be_gift_messaged</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">max_order_quantity</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">is_discontinued_by_manufacturer</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">offering_end_date</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">merchant_shipping_group_name</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">distribution_designation</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">product_tax_code</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">website_shipping_weight</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">website_shipping_weight_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_weight</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_weight_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_height</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_length</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_width</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_length_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_display_weight</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_display_weight_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_display_length</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">item_display_length_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">bullet_point1</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">bullet_point2</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">bullet_point3</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">bullet_point4x</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">bullet_point5</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">recommended_browse_nodes</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">generic_keywords</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">main_image_url</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">swatch_image_url</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">other_image_url1</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">other_image_url2</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">other_image_url3</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">other_image_url4</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">other_image_url5</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">other_image_url6</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">other_image_url7</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">other_image_url8</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">fulfillment_center_id</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">package_length</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">package_width</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">package_height</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">package_length_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">package_weight</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">package_weight_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">parent_child</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">variation_theme</div>
                                        </td>

                                        <td>
                                            <div class="table-cell">parent_sku</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">relationship_type</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">legal_disclaimer_description</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">safety_warning</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">country_string</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">country_of_origin</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">mfg_minimum</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">mfg_minimum_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">mfg_maximum</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">mfg_maximum_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">target_gender</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">warranty_description</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">assembly_instructions</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">is_assembly_required</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">assembly_time</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">assembly_time_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">minimum_weight_recommendation</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">minimum_weight_recommendation_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">maximum_weight_recommendation</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">maximum_weight_recommendation_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">minimum_height_recommendation</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">minimum_height_recommendation_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">maximum_height_recommendation</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">maximum_height_recommendation_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">folded_size</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">material_type</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">care_instructions1</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">care_instructions2</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">care_instructions3</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">special_features</div>
                                        </td>

                                        <td>
                                            <div class="table-cell">size_name</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">size_map</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">color_name</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">color_map</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">is_adult_product</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">number_of_pieces</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">number_of_players</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">subject_character</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">material_composition</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">scale_name</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">rail_gauge</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">remote_control_technology</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">frequency_bands_supported</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">engine_type</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">recommended_uses_for_product</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">educational_objective</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">collection_name</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">specific_uses_for_product</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">genre</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">handle_height</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">handle_height_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">seat_width</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">seat_width_unit_of_measure</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">are_batteries_included</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">batteries_required</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">battery_description</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">battery_type</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">number_of_batteries</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">lithium_battery_voltage</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">lithium_battery_weight</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">lithium_battery_packaging</div>
                                        </td>
                                        <td>
                                            <div class="table-cell">is_expiration_dated_product</div>
                                        </td>

                                    </tr>
                                    <!-- 5行目 -->
                                    <tr>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    echo ($ProductID_A . PHP_EOL);
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    echo ($productName  . PHP_EOL);
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    echo ($ram . PHP_EOL);
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->external_product_id_type;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"> <?php
                                                                        echo $brand_name;
                                                                        ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    echo $manufacturer;
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->feed_product_type;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->part_number;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    echo ($productName  . PHP_EOL);
                                                                    ?>です。</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->model;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->update_delete;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->quantity;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->fulfillment_latency;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell">@if(isset($buynowPrice_A))
                                                <?php
                                                foreach ($prices as $item) {
                                                    $num = $item->price; // 各データの名前を表示
                                                }

                                                $val = filter_var($buynowPrice_A, FILTER_SANITIZE_NUMBER_INT);
                                                echo $val * $nom;
                                                ?>
                                                @else
                                                <?php
                                                foreach ($prices as $item) {
                                                    $num = $item->price; // 各データの名前を表示
                                                }
                                                $val = filter_var($currentPrice_A, FILTER_SANITIZE_NUMBER_INT);
                                                echo $val * $num;
                                                ?>
                                                @endif</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->standard_price_points;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->condition_type;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->condition_note;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    echo ($productName  . PHP_EOL);
                                                                    ?>です。</div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->recommended_browse_nodes;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    echo $generic_keywords;
                                                                    ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table-cell"> <?php
                                                                        // メイン画像URL
                                                                        $imgURL = $crawler->filter('.ProductImage__inner')->filter('img')->attr("src");
                                                                        echo ($imgURL . PHP_EOL);
                                                                        ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    $subimgURL1 = $crawler->each(function ($element) {
                                                                        if (count($element->filter('.ProductImage__thumbnails')->filter('li')->eq(1))) {
                                                                            echo $element->filter('.ProductImage__thumbnails')->filter('li')->eq(1)->filter('img')->attr('src') . "\n";
                                                                        }
                                                                    });
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    $subimgURL2 = $crawler->each(function ($element) {
                                                                        if (count($element->filter('.ProductImage__thumbnails')->filter('li')->eq(2))) {
                                                                            echo $element->filter('.ProductImage__thumbnails')->filter('li')->eq(2)->filter('img')->attr('src') . "\n";
                                                                        }
                                                                    });
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    $subimgURL3 = $crawler->each(function ($element) {
                                                                        if (count($element->filter('.ProductImage__thumbnails')->filter('li')->eq(3))) {
                                                                            echo $element->filter('.ProductImage__thumbnails')->filter('li')->eq(3)->filter('img')->attr('src') . "\n";
                                                                        }
                                                                    });
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    $subimgURL4 = $crawler->each(function ($element) {
                                                                        if (count($element->filter('.ProductImage__thumbnails')->filter('li')->eq(4))) {
                                                                            echo $element->filter('.ProductImage__thumbnails')->filter('li')->eq(4)->filter('img')->attr('src') . "\n";
                                                                        }
                                                                    });
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    $subimgURL5 = $crawler->each(function ($element) {
                                                                        if (count($element->filter('.ProductImage__thumbnails')->filter('li')->eq(5))) {
                                                                            echo $element->filter('.ProductImage__thumbnails')->filter('li')->eq(5)->filter('img')->attr('src') . "\n";
                                                                        }
                                                                    });
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    $subimgURL6 = $crawler->each(function ($element) {
                                                                        if (count($element->filter('.ProductImage__thumbnails')->filter('li')->eq(6))) {
                                                                            echo $element->filter('.ProductImage__thumbnails')->filter('li')->eq(6)->filter('img')->attr('src') . "\n";
                                                                        }
                                                                    });
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    $subimgURL7 = $crawler->each(function ($element) {
                                                                        if (count($element->filter('.ProductImage__thumbnails')->filter('li')->eq(7))) {
                                                                            echo $element->filter('.ProductImage__thumbnails')->filter('li')->eq(7)->filter('img')->attr('src') . "\n";
                                                                        }
                                                                    });
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    $subimgURL8 = $crawler->each(function ($element) {
                                                                        if (count($element->filter('.ProductImage__thumbnails')->filter('li')->eq(8))) {
                                                                            echo $element->filter('.ProductImage__thumbnails')->filter('li')->eq(8)->filter('img')->attr('src') . "\n";
                                                                        }
                                                                    });
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>

                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>

                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"><?php
                                                                    foreach ($items as $item) {
                                                                        echo $item->is_adult_product;   // 各データの名前を表示
                                                                    }
                                                                    ?></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>
                                        <td>
                                            <div class="table-cell"></div>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="Div" style="margin-top: 10px;">
                        <p style=" background-color: #f0f0f0;padding: 3px 10px;border-radius: 4px 4px 0px 0px;margin-bottom: 8px;">セルの内容</p>
                        <p id="Mbox0" style="padding: 0px 10px;">選択中のセルの内容</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    //ここからCSV出力＆ダウンロード
    function handleDownload() {
        var bom = new Uint8Array([0xEF, 0xBB, 0xBF]); //文字コードをBOM付きUTF-8に指定
        var table = document.getElementById('TBL'); //id=table1という要素を取得
        var data_csv = ""; //ここに文字データとして値を格納していく

        for (var i = 1; i < table.rows.length; i++) {
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                data_csv += table.rows[i].cells[j].innerText; //HTML中の表のセル値をdata_csvに格納
                if (j == table.rows[i].cells.length - 1) data_csv += "\n"; //行終わりに改行コードを追加
                else data_csv += ","; //セル値の区切り文字として,を追加
            }
        }

        var blob = new Blob([bom, data_csv], {
            "type": "text/csv"
        }); //data_csvのデータをcsvとしてダウンロードする関数
        if (window.navigator.msSaveBlob) { //IEの場合の処理
            window.navigator.msSaveBlob(blob, "test.csv");
            //window.navigator.msSaveOrOpenBlob(blob, "test.csv");// msSaveOrOpenBlobの場合はファイルを保存せずに開ける
        } else {
            document.getElementById("download").href = window.URL.createObjectURL(blob);
        }

        delete data_csv; //data_csvオブジェクトはもういらないので消去してメモリを開放
    }
    //ここまでCSV出力＆ダウンロード
</script>
@endsection