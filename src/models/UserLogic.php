<?php
// namespace models;

// require_once '../setupDB.php';
// use PDO;
// use PDOException;
class UserLogic
{

    public PDO $pdo;

    public function __construct()
    {
        $db = new setupDB();
        $this->pdo = $db->pdo;
    }


    /**
   * ユーザを登録する
   * @param array $userData
   * @return bool $result
   */
    public function createUser($usersData) :bool
    {
        $insertUser=[];
        $insertUser['userid'] = $usersData['user_id'];
        $insertUser['mail'] = $usersData['mail'];
        $insertUser['pass'] = $usersData['pass'];

        $sql = <<<SQL
            INSERT INTO 
            users (userid, email, pass) 
            VALUES 
            (:userid,:email,:pass);
    SQL;
            $stmt = $this->pdo->prepare($sql);
            $params = array(':userid' => $insertUser['userid'], ':email' => $insertUser['mail'], ':pass' =>$insertUser['pass']);
            return $stmt->execute($params); 
    }

    /**
   * バリデーションチェック
   * @param array $userData
   * @return array $err
   */
    public function validateUsers($usersData,$validatePass = true) :array
    {
        
        $err = [];
        if(!$usersData['user_id'] = filter_input(INPUT_POST,'userid')){
            $err[] = 'ユーザーIDを記入してください';
            }
            
        if(!$userData['mail'] = filter_input(INPUT_POST, 'mail')){
            $err[] = 'メールアドレスを記入してください';
            }
                
        if ($validatePass == true){
            $password = filter_input(INPUT_POST, 'pass');
            // 正規表現
            if(!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)){
                $err[] = 'パスワードは英数字８文字以上１００文字以下にしてください。';
            }

        $password_conf = filter_input(INPUT_POST, 'confirmpass');
        if($password !== $password_conf){
            $err[] = '確認用パスワードと異なっています';
        }
        }

        return $err;
    }


    /**
   * IDの重複チェック　
   * 送信されたフォームからDBと照合
   * @param array $userData
   * @return array $id
   */
  
    public function checkDuplicate($userData) :bool
    {

        $sql = <<<SQL
        SELECT * FROM users
        WHERE userid = :userid
SQL;

        $stmt = $this->pdo->prepare($sql);
        $params = array(':userid' => $userData['user_id']);
        $result = $stmt->execute($params); 

        $id = $stmt->fetch(PDO::FETCH_ASSOC);

        if($id === false){
            return true;
        }else{
            return false;
        }
        
    }

    /**
   * ログイン処理
   * 送信されたフォームからDBと照合
   * @param array $loginData
   * @return bool $result
   */
    public function login(array $loginData) :bool
    {

        $result = false;

        $user = $this->getByUser($loginData);

        if (!$user) {
            $_SESSION['msg'] = 'ユーザーIDが一致しません。';
            return $result;

        }

        if(password_verify($loginData['password'],$user['pass'])){
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }

        $_SESSION['msg'] = 'パスワードが一致しません。';
        return $result;

    }


    public function getByUser($loginData) 
    {

        $sql = <<<SQL
        SELECT * 
        FROM users 
        WHERE userid = ?
SQL;
        $param =[];
        $param []= $loginData['userid'];
        $stmt = $this->pdo->prepare($sql); //値が空のままSQL文をセット
        $stmt->execute($param); 
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $user;
    }

    
    public static function checkLogin() :bool
    {
        $result = false;
        if(isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0){
            return $result = true;
        }

        return $result;
    }



    public static function logout() :bool
    {
        // セッションの変数のクリア
        $_SESSION = array();
        // セッションクリア
        return session_destroy();
    }


    public function updateUser($users,$current_userid) :bool
    {
        $result = false;
        try{

            $sql = <<< SQL
            UPDATE 
                users
            SET
                userid = :user_id,
                email = :mail
            WHERE
                userid = :current_user_id
            SQL;
            
            $stmt = $this->pdo->prepare($sql);
            $params = array(':current_user_id' => $current_userid,':user_id' => $users['user_id'], ':mail' => $users['mail']); 
            $stmt->execute($params);
            $_SESSION['login_user']['userid'] = $users['user_id'];
            $_SESSION['login_user']['email'] = $users['mail'];

            $result=true;
            return $result;

            }catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }

    }
    

    public function deleteUser($user_id) :bool
    {

        $sql = <<< SQL
        DELETE 
        U,FR
        FROM 
        users AS U
        LEFT OUTER JOIN fitness_record AS FR
        ON U.userid = FR.userid
        WHERE U.userid = :user_id
    SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $result = $stmt->execute();
        session_destroy();
        return $result;

    }


    


}