
    <h1>登録完了画面</h1>
    
    <?php if (count($error) > 0) :?>
    <?php foreach ($error as $e) :?>
        <p><?php echo $e ?></p>
    <?php endforeach ;?>
        <p>登録に失敗しました</p>
    <?php else :?>
        <p>ユーザ登録が完了しました。</p>
    <?php endif; ?>
    

    
    <a href="/">ログイン</a>
    <a href="/signup">戻る</a>
    
