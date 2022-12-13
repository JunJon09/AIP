<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI作品提出画面</title>
</head>
<body>
    <form method="POST" action="{{ route('ImgPost') }}" enctype="multipart/form-data">
        @csrf
        keyword: <input type="text" name="key" placeholder="-で区切って入力して">
        name : <input type="text" name="name">
        path: <input type="text" name="path">
        <input type="submit" value="提出" id="sub">
    </form>
</body>
</html>