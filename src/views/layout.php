<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <title>
        <?php if (isset($title)) : echo $title . '_' ;endif;?>
        Fitness Log
    </title>
</head>
<body>

    <h1>
        <a href="/">
            fitness log
        </a>
    </h1>

    <ul>
        <li>
            <a href="/record/create">トレーニングを記録する</a>

        </li>
        <li>
            <a href="/record">トレーニング一覧</a>

        </li>
    </ul>

    <ul class=".container">
        <li>
        <a href="/signup">
            新規会員登録
        </a>
        </li>
        <li>
            <a href="/">
                ログイン
            </a>
        </li>
        <li>
            <a href="/mypage">
                マイページ
            </a>
        </li>
    </ul>

    <div>
        <?php echo $content; ?>
    </div>

    
</body>
</html>