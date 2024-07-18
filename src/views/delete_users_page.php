<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>退会画面</title>
</head>
<body>
    <h1>退会画面</h1>

    <?php if($result === true):?>
        <p>退会しました。</p>
        <a href="/">トップページへ戻る</a>
    <?php else:?>
        <p>退会できませんでした。</p>
        <p>もう一度やり直してください。</p>
        <a href="mypage.php">マイページへ戻る</a>
    <?php endif;?>



    
</body>
</html> 

