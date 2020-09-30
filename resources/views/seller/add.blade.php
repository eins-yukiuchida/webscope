@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="/seller/add" method="post">
                        <table>
                            @csrf
                            <input type="hidden" name="id">
                            <tr>
                                <th>yahoo_id:</th>
                                <td><input type="text" name="yahoo_id" required></td>
                            </tr>
                            <tr>
                                <th>
                                <td><input type="submit" value="登録する"></td>
                                </th>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> @endsection