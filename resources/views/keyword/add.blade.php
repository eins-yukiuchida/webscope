@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="/keyword/add" method="post">
                        <table>
                            @csrf
                            <input type="hidden" name="id">
                            <tr>
                                <th>keyword:</th>
                                <td><input type="text" name="keyword" required></td>
                            </tr>
                            <tr>
                                <th>brand_name:</th>
                                <td><input type=" text" name="brand_name" required></td>
                            </tr>
                            <tr>
                                <th>manufacturer:</th>
                                <td><input type="text" name="manufacturer" required></td>
                            </tr>
                            <tr>
                                <th>generic_keywords:</th>
                                <td><input type="text" name="generic_keywords" required></td>
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