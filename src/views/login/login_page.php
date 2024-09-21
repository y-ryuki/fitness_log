    
<h1>ログイン</h1>
<?php if (isset($error) ) : ?>
    <?php foreach($error as $e):?>
        <p><?php echo $e; ?></p>
    <?php endforeach;?>
        <p>もう一度やり直してください</p>
    <?php endif; ?>
    
    <form action="login" method="post">
    <div>
        <label>
            ユーザーID:
            <input type="text" name="userid">
        </label>
       
    </div>

    <div>
        <label>
            パスワード：
            <input type="password" name="pass">
        </label>
        
    </div>

    <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
    <input type="submit" value="ログイン">
    </form>

    <a href="signup">新規会員登録をする</a>

