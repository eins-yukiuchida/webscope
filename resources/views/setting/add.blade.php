@extends('layouts.app')

@section('content')

<form action="/hello/add" method="post">
    <table>
        @csrf
        <input type="hidden" name="id">
        <tr>
            <th>feed_product_type:</th>
            <td><input type="text" name="feed_product_type"></td>
        </tr>
        <tr>
            <th>quantity:</th>
            <td><input type=" text" name="quantity"></td>
        </tr>
        <tr>
            <th>recommended_browse_nodes:</th>
            <td><input type="text" name="recommended_browse_nodes"></td>
        </tr>
        <tr>
            <th>fulfillment_latency:</th>
            <td><input type="text" name="fulfillment_latency"></td>
        </tr>
        <tr>
            <th>condition_type:</th>
            <td><input type="text" name="condition_type"></td>
        </tr>
        <tr>
            <th>condition_note:</th>
            <td><input type="text" name="condition_note"></td>
        </tr>
        <tr>
            <th>standard_price_points:</th>
            <td><input type="text" name="standard_price_points"></td>
        </tr>
        <tr>
            <th>
            <td><input type="submit" value="send"></td>
            </th>
        </tr>
    </table>
</form>
@endsection