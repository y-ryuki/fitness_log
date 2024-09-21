
    <h1>退会画面</h1>

    <?php if($result === true):?>
        <p>退会しました。</p>
        <a href="/">トップページへ戻る</a>
    <?php else:?>
        <p>退会できませんでした。</p>
        <p>もう一度やり直してください。</p>
        <a href="/mypage">マイページへ戻る</a>
    <?php endif;?>

