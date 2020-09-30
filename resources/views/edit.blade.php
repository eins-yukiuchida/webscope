@extends('layouts.app')

@section('content')

<form action="/edit" method="post">
    <table>
        @csrf
        <input type="hidden" name="id" value="{{$form->id}}">
        <tr>
            <th>name:</th>
            <td><input type="text" class="readonly" name="name" value="{{$form->name}}" readonly="readonly"></td>
        </tr>
        <tr>
            <th>mail:</th>
            <td><input type="text" name="email" value="{{$form->email}}"></td>
        </tr>
        <tr>
            <th>age:</th>
            <td><input type="text" name="password" value="{{$form->password}}"></td>
        </tr>
        <tr>
            <th>
            <td><input type="submit" value="send"></td>
            </th>
        </tr>
    </table>
</form>
@endsection