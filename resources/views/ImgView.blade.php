<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像</title>
    @vite(['resources/css/imgView.css'])
</head>
<body>
    <div>
        <a href="{{$download}}" download="download.png">画像はこちらからダウンロード</a>
    </div>
    <div class="center">
        <img src="{{$path}}" width="100" height="100" alt="otter">
    </div>
</body>
</html>