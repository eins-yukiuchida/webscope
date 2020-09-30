@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">管理側TOP</div>
        <div class="card-body">
            <div>
                <a href="{{ url('admin/resister') }}" class="btn btn-primary">新規ユーザー登録</a>
            </div>
            <form method="post" action="{{ url('admin/logout') }}">
                @csrf
                <input type="submit" class="btn btn-danger" value="ログアウト" />
            </form>
        </div>
    </div>
</div>
@endsection