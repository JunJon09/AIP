<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トップ画面</title>
    @vite(['resources/css/style.css'])
</head>
<body>
    <div id="top">
        <h1>AIP</h1>
        <h2>AIが生み出した写真や絵を検索</h2>
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <form method="POST" action="{{ route('look') }}" enctype="multipart/form-data" class="search_container">
        @csrf
            <input type="text"  placeholder="キーワード検索" name="word" required="required">
            <input type="submit" value="&#xf002">
        </form>
    </div>
</body>

</html>