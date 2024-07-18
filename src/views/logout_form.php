<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
</head>
<body>
    <h1>ログアウト画面</h1>
    <a href="/">ログインページはこちら</a>
    
    <?php if(isset($msg)):?>
        <p><?php echo $msg;?></p>
    <?php endif;?>
    
</body>
</html>