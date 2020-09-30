@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="/price/edit" method="post">
                        <table>
                            @csrf
                            <input type="hidden" name="id" value="{{$form->id}}">
                            <tr>
                                <th>販売価格:</th>
                                <td>×<input type="text" name="price" value="{{$form->price}}">倍</td>
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