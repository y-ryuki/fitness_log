

<?php if(!$result) :?>
        <p><?php echo $msg?></p>
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