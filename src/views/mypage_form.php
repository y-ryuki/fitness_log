<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
</head>
<body>
    <h1>
        マイページ


    <ul>
        <li>
            <a href="/record/create">トレーニングを記録する</a>

        </li>
        <li>
            <a href="/record">トレーニング一覧</a>

        </li>
    </ul>
    


    <?php if(!$result) :?>
        <p><?php echo $_SESSION['msg']?></p>
        <a href="/">ログインはこちら</a>
        <a href="/">新規登録はこちら</a>
    
    <?php else:?>
        <p>ログインユーザ：<?php echo h($login_user['userid'])?></p>
        <p>メールアドレス：<?php echo h($login_user['email']) ?></p>

        <form action="/logout" method="POST">
            <input type="submit" name="logout" value="ログアウト">
        </form>

        <a href="/edit">ユーザ情報変更</a>
        
        <form action="/delete" method="POST">
        <input type="submit" value="退会する">

    </form>

    <?php endif;?>



    
</body>
</html>