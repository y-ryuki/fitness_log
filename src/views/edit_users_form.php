<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザ情報の変更</title>
</head>
<body>
    <h1>ユーザ情報の変更</h1>

    <p>現在のユーザID:<?php echo $login_user['userid'];?></p>
    
    <p>現在のメールアドレス:<?php echo $login_user['email'];?></p>

    <form action="/update" method="POST">
        <div>

            <p>新規ユーザID</p>
            <input type="text" name="userid" >
        </div>
        <div>

            <p>新規メールアドレス</p>
            <input type="text" name="mail" >
        </div>

        <div>

            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>" />
            <input type="submit" value="変更する">
        </div>

    </form>

    
</body>
</html>