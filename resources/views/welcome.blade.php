@extends('layouts.app')

@section('content')
<table border="1" id="TBL">
    <tr>
        <th><a href="javascript:void(0)" style="background-color:pink;">入力フォーム</a></th>
        <th><span style="color : red;">画像</span></th>
        <th>文字列</th>
    </tr>
    <tr>
        <td><input type="checkbox">：チェックボックス</td>
        <td><strong style="color : teal;">ドラッグして移動</strong></td>
        <td><a href="javascript:void(0)">流れる文字</a></td>
    </tr>
    <tr>
        <td><input type="button" value="ボタン" style="background-color:#eeffff;"></td>
        <td><code>&lt;img src=&quot;**.gif&quot;&gt;</code></td>
        <td><cite>文字数取得</cite></td>
    </tr>
</table>
<br>
<div id="Div">
    <p id="Mbox0">セルをクリックしたらここに書き出します。</p>
    <p id="Mbox1">インデックス値は '0'から始まります。</p>
</div>
@endsection