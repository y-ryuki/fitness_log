<?php



    
    /**
     * XSS対策：エスケープ処理
     * 
     * @param string $str 対象の文字列
     * @return string 処理された文字列
     */
    function h($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
    
    
    function Token()
    {
        
        // セッションの利用を開始
        // session_start();
        // ワンタイムトークン生成
        $toke_byte = openssl_random_pseudo_bytes(16);
        $csrf_token = bin2hex($toke_byte);
        
        // トークンをセッションに保存
        $_SESSION['csrf_token'] = $csrf_token;
        
        return $csrf_token;
        
        
    }
    
    



