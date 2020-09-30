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
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <ul class="navbar-nav mr-auto">
                            <li role="presentation"><a href="/" style="color: black;margin-right: 20px;">情報取得</a></li>

                            <li role="presentation" class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false" style="color: black;">
                                    各種設定 <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu" style="width: 160px;padding: 10px;">
                                    <li role="presentation"><a href="/setting/paramter" style="color: black;">定型パラメータ</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li role="presentation"><a href="/keyword" style="color: black;">キーワード</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li role="presentation"><a href="/price" style="color: black;">販売価格設定</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li role="presentation"><a href="/seller" style="color: black;">除外オークションID</a></li>
                                </ul>
                            </li>
                        </ul>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links  -->
                        @guest
                        <li class="nav-item">
                            <!--<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>-->
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <!-- <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>-->
                        </li>
                        @endif

                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>