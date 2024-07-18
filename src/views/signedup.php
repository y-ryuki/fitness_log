<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了画面</title>
</head>
<body>
    <h1>登録完了画面</h1>
    <ul>
        <li>
            <a href="../CRUD/record.php">トレーニングを記録する</a>

        </li>
        <li>
            <a href="../CRUD/recordlist.php">トレーニング一覧</a>

        </li>
    </ul>
    
    <?php if (count($err) > 0) :?>
    <?php foreach ($err as $e) :?>
        <p><?php echo $e ?></p>
    <?php endforeach ?>
    <?php else :?>
        <p>ユーザ登録が完了しました。</p>
    <?php endif; ?>
    
    <a href="/">ログイン</a>
    <a href="/signup">戻る</a>
    
</body>
</html>