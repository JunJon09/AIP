<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/vue-infinite-loading@2.4.4/dist/vue-infinite-loading.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/popUpWindow.js'])
    <title>フリ-素材検索</title>
</head>
<body>
    <div class="hamburger-menu">
        <input type="checkbox" id="menu-btn-check">
        <label for="menu-btn-check" class="menu-btn"><span></span></label>
        <!--ここからメニュー-->
        <div class="menu-content">
            <ul>
                <li>    
                    <a href="#">
                        <img src="{{ asset('img/AIP.png')}}" alt="ロゴ" width=80px id="logo">
                    </a>
                </li>   
                <li>
                    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
                    <form method="POST" action="{{ route('look') }}" enctype="multipart/form-data" class="search_container">
                        @csrf
                    <input type="text"  placeholder="キーワード検索" name="word" required="required" value="{{$word}}">
                    <input type="submit" value="&#xf002">
                </form>
                </li>
                
                
            </ul>
        </div>
        <!--ここまでメニュー-->
    </div>
    <section id="left">
        <div class="side">
            <a href="#">
                <img src="{{ asset('img/AIP.png')}}" alt="ロゴ" width=80px id="logo">
            </a>
            <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
            <form method="POST" action="{{ route('look') }}" enctype="multipart/form-data" class="search_container">
            @csrf
                <input type="text"  placeholder="キーワード検索" name="word" required="required" value="{{$word}}">
                <input type="submit" value="&#xf002">
            </form>
        </div>
    </section>
    <main>
        <div id="top">
            <header>
                <h1 id="key">{{$word}}</h1>   
            </header>    
            <div id="view">
                <div v-for="item in items" :key="item.id" class="imgs">
                    <img v-bind:src="item.img" alt="aaa" onClick="pop(this.src)">
                </div>
                <infinite-loading @infinite="fetchImgs" id="infinite">
                    <div slot="no-more">全件取得しました</div>
                </infinite-loading>
            </div> 
        </div>
    </main>
    <!-- モーダルウィンドウ -->
    <div class="modal-block">
        <div class="img-section">
            <span>
            <!-- close btn -->
            </span>
            <img id="popup" src="クリックした画像のパスが入ります">
            <div class="caption">
                <a href="ここ編集" download="download.png" id='imgDownload'>画像はこちらからダウンロード</a>
            </div>
        </div>
    </div>
    <script>
    function pop($path){
        $(".modal-block").fadeIn();
        $(".modal-block").css("display", "flex")
        $("#popup").attr("src", $path);
        $("#imgDownload").attr("href", $path);
    }
    $(".img-section >span").click(function () {
        $(".modal-block").css("display", "none")
    })
    </script>
</body>
</html>