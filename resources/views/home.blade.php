@extends('layouts.app')

@section('content')
<h1>CSV出力</h1>
<form action="" method="post">
    @csrf
    <table border="1" width="200">
        <tr>
            <th>名前</th>
            <th>年齢</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user['name'] }}</td>
            <td>{{ $user['age'] }}</td>
        </tr>
        @endforeach
    </table>
    <button type="submit">CSV出力</button>
</form>
<script>
    //updateBar
    function updateBar(per) {
        var status = per + '%';
        $('#progress_elem').css({
            width: status
        }).text(status);
    }

    //ajax
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#btnInfo").on('click', function() {
            let urlList = hot.getDataAtCol(0);
            urlList = urlList.filter(function(s) {
                return s !== '';
            }); //空文字列の要素を削除
            urlList = urlList.filter(function(s) {
                return s !== null;
            }); //nullの要素を削除

            let urlCount;
            urlCount = urlList.length;

            if (urlCount == 0) {
                alert('商品URLを入力してください。');
                return true;
            }

            if (urlCount > 200) {
                alert('商品URLは200件以下にしてください。');
                return true;
            }

            if (confirm('商品情報の取得を開始します。よろしいですか？')) {
                $('#btnInfo').prop('disabled', true);
                $('#btnCreate').prop('disabled', true);
                $('#btnDownload').prop('disabled', true);

                updateBar(0);
                $('#progressArea').slideDown();

                for (let rowNum = 0; rowNum < hot.countRows(); rowNum++) {
                    for (let colNum = 1; colNum <= 4; colNum++) {
                        hot.setDataAtCell(rowNum, colNum, '');
                    }
                }

                let count = 0;
                var intervalId = setInterval(function() {
                    count++; //100ミリ秒単位
                    let per = Math.round(((count * 100) / (urlCount * 1100)) * 100);
                    if (per > 99) {
                        per = 99;
                    }
                    updateBar(per);
                    if (per == 99) {
                        clearInterval(intervalId);
                    }
                }, 100);

                $.post({
                        url: '/result',
                        data: {
                            'url_list': urlList.join("\n")
                        }
                    })
                    //成功
                    .done((data) => {
                        updateBar(99);
                        $('#data').val(data.data);
                        $('#btnInfo').prop('disabled', false);
                        $('#btnCreate').prop('disabled', false);

                        let rows = JSON.parse(data.data);
                        let i = 0;
                        for (row of rows) {
                            i++;

                            let maxRows = hot.countRows();

                            for (let rowNum = 0; rowNum < maxRows; rowNum++) {
                                if (hot.getDataAtCell(rowNum, 0) == row.url) {
                                    let item_name;
                                    if (row.seller == 1) {
                                        item_name = row.item_name;
                                    } else {
                                        item_name = '※CSV出力対象外（除外ヤフオクセラー）';
                                        row.price_current = '';
                                        row.price_buynow = '';
                                        row.status = '';
                                    }
                                    hot.setDataAtCell(rowNum, 1, item_name);
                                    hot.setDataAtCell(rowNum, 2, row.price_current);
                                    hot.setDataAtCell(rowNum, 3, row.price_buynow);
                                    hot.setDataAtCell(rowNum, 4, row.status);
                                }
                            }

                            for (let rowNum = 0; rowNum < maxRows; rowNum++) {
                                let cell1 = hot.getDataAtCell(rowNum, 0);
                                if (cell1 != '' && cell1 != null) {
                                    let cell2 = hot.getDataAtCell(rowNum, 1);
                                    if (cell2 == '' || cell2 == null) {
                                        hot.setDataAtCell(rowNum, 1, '※CSV出力対象外（終了したオークション）');
                                    }
                                }
                            }
                        }
                        updateBar(100);

                        setTimeout(function() {
                            $('#progressArea').slideUp();
                        }, 500);

                        setTimeout(function() {
                            alert('商品情報の取得を完了しました。');
                        }, 1000);

                    })
                    //失敗
                    .fail((data) => {
                        $('#btnInfo').prop('disabled', false);
                        $('#progressArea').hide();
                        alert('エラーが発生しました。');
                    })
                    //成功・失敗 共通
                    .always((data) => {

                    });
            }
        });

        $("#btnCreate").on('click', function() {
            $('#btnCreate').prop('disabled', true);
            $('#btnDownload').prop('disabled', true);

            hotCsv.alter('remove_row', 3, (hotCsv.countRows() - 3));

            $.post({
                    url: '/result',
                    data: {
                        'data': $('#data').val()
                    }
                })
                //成功
                .done((data) => {
                    $('#btnCreate').prop('disabled', false);
                    $('#btnDownload').prop('disabled', false);

                    let rows = JSON.parse(data.data);
                    hotCsv.populateFromArray(3, 0, rows);
                })
                //失敗
                .fail((data) => {
                    $('#btnCreate').prop('disabled', false);
                    alert('エラーが発生しました。');
                })
                //成功・失敗 共通
                .always((data) => {

                });
        });


        $("#btnDownload").on('click', function() {
            let maxRows = hotCsv.countRows();
            let maxCols = hotCsv.countCols();
            let data = '';

            for (let r = 0; r < maxRows; r++) {
                for (let c = 0; c < maxCols; c++) {
                    data += hotCsv.getDataAtCell(r, c);
                    if (c < (maxCols - 1)) {
                        data += "\t";
                    }
                }
                data += "\n";
            }

            data += '$$$EOF$$$';
            $('#csv_data').val(data);
            $('#frm').submit();
        });


        let data = [];

        var hotElement = document.querySelector('#grid');

        var hotSettings = {
            data: data,
            minSpareRows: 1, //表の一番下にいくつ空行を表示するか
            colHeaders: ['商品URL', '商品タイトル', '現在価格', '即決価格', '状態'],
            columns: [{
                    type: 'text',
                    width: 100
                },
                {
                    type: 'text',
                    width: 630
                },
                {
                    type: 'numeric',
                    width: 80
                },
                {
                    type: 'numeric',
                    width: 80
                },
                {
                    type: 'text'
                }
            ],
            rowHeaders: true, //行番号を表示
            minRows: 10,
            width: '100%',
            height: 257,
            stretchH: 'last',
            contextMenu: true, //セルを右クリックしたときのメニューをすべて表示
            manualColumnResize: true,
            licenseKey: 'non-commercial-and-evaluation'
        };

        var hot = new Handsontable(hotElement, hotSettings);


        data = [];
        data.push('TemplateType=fptcustom	Version=2019.0115	上3行は Amazon.com 記入用です。上3行は変更または削除しないでください。.									出品情報-商品をサイト上で販売可能にする際に必要な項目																										寸法-商品のサイズや重量を入力する項目												商品検索情報-サーチ上で商品を検索されやすくするために必要な項目							画像-商品画像を表示させるために必要な項目。詳しくは画像説明タブを参照										出荷関連情報-フルフィルメント by Amazon (FBA) の利用、あるいは自社出荷の注文に関する出荷関連情報を、この項目に記入してください。FBA を利用する場合には必須の項目。							バリエーション-商品の色・サイズなどのバリエーションを作成する際に必須の項目				コンプライアンス情報-商品を販売する国または地域の特定商取引に遵守するために利用される項目				ProductTypeによって必須となる項目																																																							'.split("\t"));
        data.push('出品者SKU	商品名	商品コード(JANコード等)	商品コードのタイプ	ブランド名	メーカー名	商品タイプ	メーカー型番	商品説明文	型番	アップデート・削除	在庫数	出荷作業日数	商品の販売価格	ポイント	商品のコンディション	商品のコンディション説明	商品の公開日	予約商品の販売開始日	商品の入荷予定日	使用しない支払い方法	配送日時指定SKUリスト	セール価格	セール時ポイント	セール開始日	セール終了日	パッケージ商品数	メーカー希望価格	付属品総数	ギフト包装	ギフトメッセージ	最大注文個数	メーカー製造中止	廃盤日	配送パターン	販売形態(並行輸入品)	商品タックスコード	発送重量	発送重量の単位	商品の重量	商品の重量の単位	商品の高さ	商品の長さ	商品の幅	商品寸法の単位	商品の重量	商品の重量の単位	商品の長さ	商品の長さの単位	商品説明の箇条書き1	商品説明の箇条書き2	商品説明の箇条書き3	商品説明の箇条書き4	商品説明の箇条書き5	推奨ブラウズノード	検索キーワード	商品メイン画像URL	カラーサンプル画像URL	商品サブ画像URL1	商品サブ画像URL2	商品サブ画像URL3	商品サブ画像URL4	商品サブ画像URL5	商品サブ画像URL6	商品サブ画像URL7	商品サブ画像URL8	フルフィルメントセンターID	商品パッケージの長さ	商品パッケージの幅	商品パッケージの高さ	商品パッケージの長さの単位	商品パッケージの重量	商品パッケージの重量の単位	親子関係の指定	バリエーションテーマ	親商品のSKU(商品管理番号)	親子関係のタイプ	法規上の免責条項	安全性の注意点	製造国	原産国	メーカー推奨最少年齢	メーカー推奨最少年齢の単位	メーカー推奨最高年齢	メーカー推奨最高年齢の単位	対象性別	メーカー保証の説明	組み立て方法	要組み立て	組み立て時間	組み立て時間の単位	メーカー推奨最少体重	メーカー推奨最少体重の単位	メーカー推奨最大体重	メーカー推奨最大体重の単位	推奨最低身長	推奨最低身長の単位	推奨最高身長	推奨最高身長の単位	折りたたみ時のサイズ	素材タイプ	お取り扱い上の注意1	お取り扱い上の注意2	お取り扱い上の注意3	特殊機能	サイズ	サイズマップ	カラー	カラーマップ	アダルト商品	商品の個数(ピース数)	最大プレーヤー数	キャラクター	素材構成	スケール	レールのゲージ	リモコンのタイプ	サポートしている周波数帯域	エンジンタイプ	推奨使用方法・場所	教育目的	コレクション名	トレーディングカードのタイプ	トレーディングカードのジャンル	ハンドルの高さ	ハンドルの高さの単位	座面（椅子）の幅	座面（椅子）の幅の単位	電池付属	電池の必要性	電池の説明	電池のタイプ	付属バッテリ個数	リチウム電池エネルギー含有量	リチウム電池重量	リチウム電池パッケージ仕様	is_expiration_dated_product'.split("\t"));
        data.push('item_sku	item_name	external_product_id	external_product_id_type	brand_name	manufacturer	feed_product_type	part_number	product_description	model	update_delete	quantity	fulfillment_latency	standard_price	standard_price_points	condition_type	condition_note	product_site_launch_date	merchant_release_date	restock_date	optional_payment_type_exclusion	delivery_schedule_group_id	sale_price	sale_price_points	sale_from_date	sale_end_date	item_package_quantity	list_price	number_of_items	offering_can_be_giftwrapped	offering_can_be_gift_messaged	max_order_quantity	is_discontinued_by_manufacturer	offering_end_date	merchant_shipping_group_name	distribution_designation	product_tax_code	website_shipping_weight	website_shipping_weight_unit_of_measure	item_weight	item_weight_unit_of_measure	item_height	item_length	item_width	item_length_unit_of_measure	item_display_weight	item_display_weight_unit_of_measure	item_display_length	item_display_length_unit_of_measure	bullet_point1	bullet_point2	bullet_point3	bullet_point4	bullet_point5	recommended_browse_nodes	generic_keywords	main_image_url	swatch_image_url	other_image_url1	other_image_url2	other_image_url3	other_image_url4	other_image_url5	other_image_url6	other_image_url7	other_image_url8	fulfillment_center_id	package_length	package_width	package_height	package_length_unit_of_measure	package_weight	package_weight_unit_of_measure	parent_child	variation_theme	parent_sku	relationship_type	legal_disclaimer_description	safety_warning	country_string	country_of_origin	mfg_minimum	mfg_minimum_unit_of_measure	mfg_maximum	mfg_maximum_unit_of_measure	target_gender	warranty_description	assembly_instructions	is_assembly_required	assembly_time	assembly_time_unit_of_measure	minimum_weight_recommendation	minimum_weight_recommendation_unit_of_measure	maximum_weight_recommendation	maximum_weight_recommendation_unit_of_measure	minimum_height_recommendation	minimum_height_recommendation_unit_of_measure	maximum_height_recommendation	maximum_height_recommendation_unit_of_measure	folded_size	material_type	care_instructions1	care_instructions2	care_instructions3	special_features	size_name	size_map	color_name	color_map	is_adult_product	number_of_pieces	number_of_players	subject_character	material_composition	scale_name	rail_gauge	remote_control_technology	frequency_bands_supported	engine_type	recommended_uses_for_product	educational_objective	collection_name	specific_uses_for_product	genre	handle_height	handle_height_unit_of_measure	seat_width	seat_width_unit_of_measure	are_batteries_included	batteries_required	battery_description	battery_type	number_of_batteries	lithium_battery_voltage	lithium_battery_weight	lithium_battery_packaging	is_expiration_dated_product'.split("\t"));

        var hotElementCsv = document.querySelector('#gridCsv');

        var hotSettingsCsv = {
            data: data,
            colHeaders: true,
            autoColumnSize: false,
            rowHeaders: true,
            width: '100%',
            wordWrap: false,
            height: 274,
            contextMenu: true,
            manualColumnResize: true,
            licenseKey: 'non-commercial-and-evaluation',
            afterSelection: function(r, c, r2, c2) {
                $('#selectCell').text(hotCsv.getDataAtCell(r, c));
            }
        };

        var hotCsv = new Handsontable(hotElementCsv, hotSettingsCsv);
    });
</script>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">ヤフオクから情報取得</div>

                <div class="panel-body">

                    <form id="frm" class="form-horizontal" method="POST" action="https://kuratal.com/yacsv/csv/download">
                        <input type="hidden" name="_token" value="Nkg5HcSMnmgP4okqUpyMOvIZVkQhRX6hOedTMtfi">
                        <input type="hidden" class="form-control" id="data" name="data">
                        <input type="hidden" class="form-control" id="csv_data" name="csv_data">
                        <p>
                            <button type="button" class="btn btn-primary" id="btnInfo">商品情報取得</button>
                            <button type="button" class="btn btn-primary" disabled="disabled" id="btnCreate">CSV作成</button>
                            <button type="button" class="btn btn-success" disabled="disabled" id="btnDownload">CSV出力</button>
                        </p>

                        <br>

                        <div id="progressArea" style="display:none;">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <span style="font-size: 15px;">商品情報を取得中</span><br>
                                    <div class="progress">
                                        <div id="progress_elem" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div id="grid" class="handsontable"></div>
                    <br>
                    <span style="font-size:16px"><strong>CSVの確認</strong></span><br>

                    <table id="selectCellTable" style="width: 100%;margin-bottom:10px;">
                        <tr>
                            <td style="border:1px solid #ccc;padding:3px;background-color:#f0f0f0;">選択中のセル</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #ccc;padding:3px;height:55px;vertical-align:top;"><span id="selectCell">&nbsp;</span></td>
                        </tr>
                    </table>

                    <div id="gridCsv" class="handsontable"></div>
                    <br>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection