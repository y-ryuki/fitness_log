<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
    
<h1>ログイン</h1>
<?php if (isset($err['msg'])) : ?>
        <p><?php echo $err['msg']; ?></p>
    <?php endif; ?>
    
    <form action="login" method="post">
    <div>
        <label>
            ユーザーID:
            <input type="text" name="userid">
        </label>
        <?php if (isset($err['userid'])) : ?>
        <p><?php echo $err['userid']; ?></p>
    <?php endif; ?>
    </div>

    <div>
        <label>
            パスワード：
            <input type="password" name="pass">
        </label>
        <?php if (isset($err['password'])) : ?>
        <p><?php echo $err['password']; ?></p>
    <?php endif; ?>
    </div>

    <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
    <input type="submit" value="ログイン">
    </form>

    <a href="signup">新規会員登録をする</a>

</body>
</html>