@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="/setting/edit" method="post">
                        <table>
                            @csrf
                            <input type="hidden" name="id" value="{{$form->id}}">
                            <tr>
                                <th>feed_product_type:</th>
                                <td><input type="text" name="feed_product_type" value="{{$form->feed_product_type}}"></td>
                            </tr>
                            <tr>
                                <th>quantity:</th>
                                <td><input type="text" name="quantity" value="{{$form->quantity}}"></td>
                            </tr>
                            <tr>
                                <th>recommended_browse_nodes:</th>
                                <td><input type="text" name="recommended_browse_nodes" value="{{$form->recommended_browse_nodes}}"></td>
                            </tr>
                            <tr>
                                <th>fulfillment_latency:</th>
                                <td><input type="text" name="fulfillment_latency" value="{{$form->fulfillment_latency}}"></td>
                            </tr>
                            <tr>
                                <th>condition_type:</th>
                                <td><input type="text" name="condition_type" value="{{$form->condition_type}}"></td>
                            </tr>
                            <tr>
                                <th>condition_note:</th>
                                <td><input type="text" name="condition_note" value="{{$form->condition_note}}"></td>
                            </tr>
                            <tr>
                                <th>standard_price_points:</th>
                                <td><input type="text" name="standard_price_points" value="{{$form->standard_price_points}}"></td>
                            </tr>
                            <tr>
                                <th>part_number:</th>
                                <td><input type="text" name="part_number" value="{{$form->part_number}}"></td>
                            </tr>
                            <tr>
                                <th>external_product_id_type:</th>
                                <td><input type="text" name="external_product_id_type" value="{{$form->external_product_id_type}}"></td>
                            </tr>
                            <tr>
                                <th>model:</th>
                                <td><input type="text" name="model" value="{{$form->model}}"></td>
                            </tr>
                            <tr>
                                <th>update_delete:</th>
                                <td><input type="text" name="update_delete" value="{{$form->update_delete}}"></td>
                            </tr>
                            <tr>
                                <th>is_adult_product:</th>
                                <td><input type="text" name="is_adult_product" value="{{$form->is_adult_product}}"></td>
                            </tr>
                            <tr>
                                <th>
                                <td><input type="submit" value="send"></td>
                                </th>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection