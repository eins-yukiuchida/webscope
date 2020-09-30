<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script language="javascript">
        function getCELL() {
            var myTbl = document.getElementById('TBL');
            // trをループ。rowsコレクションで,行位置取得。
            for (var i = 0; i < myTbl.rows.length; i++) {
                // tr内のtdをループ。cellsコレクションで行内セル位置取得。
                for (var j = 0; j < myTbl.rows[i].cells.length; j++) {
                    var Cells = myTbl.rows[i].cells[j]; //i番行のj番列のセル "td"
                    // onclickで 'Mclk'を実行。thisはクリックしたセル"td"のオブジェクトを返す。
                    Cells.onclick = function() {
                        Mclk(this);
                    }
                }
            }
        }

        function Mclk(Cell) {
            var rowINX = '行位置：' + Cell.parentNode.rowIndex; //Cellの親ノード'tr'の行位置
            var cellINX = 'セル位置：' + Cell.cellIndex;
            var cellVal = Cell.innerHTML;
            //取得した値の書き出し
            res = cellVal;
            document.getElementById('Mbox0').innerHTML = res;
            var Ms1 = document.getElementById('Mbox1')
            Ms1.innerText = Cell.innerHTML;
            Ms1.textContent = Cell.innerHTML;
        }
        // try ～ catch 例外処理、エラー処理
        // イベントリスナーaddEventListener,attachEventメソッド
        try {
            window.addEventListener("load", getCELL, false);
        } catch (e) {
            window.attachEvent("onload", getCELL);
        }
    </script>
</head>

<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div>
                            <div style="text-align:center;font-size: 50px;font-family: sans-serif;">{{ __('Login') }}</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <div class="col-md-8" style="margin:auto;">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Mail Address">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-8" style="margin:auto;">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    ログイン情報を保存する
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="margin:40px;text-align:center;">
                                        <div style="margin:40px;">
                                            <button type=" submit" class="btn btn-primary">
                                                {{ __('ログイン') }}
                                            </button>
                                        </div>
                                        <!--<div style="margin:40px;">
                                @if (Route::has('password.request')) <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>