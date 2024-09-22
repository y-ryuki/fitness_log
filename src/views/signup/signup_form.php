
    
    
    <form action="signup/register" method="post">
    <div>
        <label>
            ユーザーID:
            <input type="text" name="userid" required>
        </label>
    </div>
    <div>
        <label>
            メールアドレス：
            <input type="text" name="mail" required>
        </label>
    </div>
    <div>
        <label>
            パスワード：
            <input type="password" name="pass" required>
        </label>
    </div>
    <div>
        <label>
            確認パスワード：
            <input type="password" name="confirmpass" required>
        </label>
    </div>

    <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />

    <input type="submit" value="新規登録">
    </form>
    <p>すでに登録済みの方は<a href="/">こちら</a></p>

    