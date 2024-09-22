<?php 

require_once '../func.php';

class LoginController extends Controller
{
    private $user_logic;

    public function __construct()
    {
        $this->user_logic = new UserLogic();
    }

    public function index()
    {
        session_start();
        $csrf_token = Token();

        $result = $this->user_logic->checkLogin();
        if($result) {
            return $this->mypage();
        }   

        
        return $this->render([
            'csrf_token' => $csrf_token,
            'error' => []
        ],'login_page');
    }

    public function login()
    {
        session_start();

        $token = filter_input(INPUT_POST, 'csrf_token');

        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            exit('不正なリクエスト');
        }

        unset($_SESSION['csrf_token']);

        $loginData = [
            'userid' => h($_POST['userid']),
            'password' => h($_POST['pass']),
        ];

        $err = [];

        if(!$loginData['userid'] = filter_input(INPUT_POST, 'userid')) {
            $err['userid'] = 'ユーザーIDを記入してください。';
        }
        if(!$loginData['password'] = filter_input(INPUT_POST, 'pass')) {
            $err['password'] = 'パスワードを記入してください。';
        }

        if (count($err) > 0) {
            return $this->render([
                'error' => $err
            ],'login_page');

        }
         // ログイン成功時の処理
        $result = $this->user_logic->login($loginData);        
        // ログイン失敗時の処理
        if (!$result) {
            $err[] = $_SESSION['msg'];
            return $this->render([
                'error' => $err
            ],'login_page');
            
        }else{
            
            return $this->mypage();
            
        }

    }

        
        public function logout()
        {
            session_start();
            $result = UserLogic::logout();

            if($result){
                $_SESSION['msg'] = 'ログアウトしました。';
            }else{
                $_SESSION['msg'] = 'ログアウトできませんでした。もう一度やり直してください。';
            }

            $msg = $_SESSION['msg'];

            return $this->render([
                'title' => 'ログアウト',
                'msg' => $_SESSION['msg']
            ],'logout_form');
            

        }

    
    public function edit()
    {
        session_start();

        $csrf_token = Token();
    
        if(!isset($_SESSION['login_user'])){
            $_SESSION['err'] = 'ログインをもう一度やり直してください';
        }
    
        $err =[];
        $err[] = $_SESSION;
        
        $login_user = $_SESSION['login_user'];
        return $this->render([
            'title' => '編集',
            'login_user' => $login_user,
            'csrf_token' => $csrf_token,
            'error' => $err
        ],'edit_users_form');

        
    }

    
    public function update()
    {
        session_start();

        $login_user = $_SESSION['login_user'];

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('不正なリクエストです。');
        }
        unset($_SESSION['csrf_token']);

        $current_userid = $login_user['userid'];


        if($_SERVER["REQUEST_METHOD"] == "POST"){
        $updateUsers = [
            'user_id' => h($_POST['userid']),
            'mail' => h($_POST['mail']),
            
        ];

        
        //パスワードのバリデーションチェックをしない
        $validatePass = false;
        $err =  $this->user_logic->validateUsers($updateUsers,$validatePass);
        $err = $this->user_logic->checkDuplicate($updateUsers);
        $err=[];
        if (count($err) > 0) {
            // エラーがあった場合は戻す
            $_SESSION = $err;
            header('Location:/mypage');
            return;
        }else{
            
            
            $result = $this->user_logic->updateUser($updateUsers,$current_userid);
            if ($result == true){
                return $this->mypage();
        
            }
            
            
        }
        }
    }


    public function mypage()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        

        $result = UserLogic::checkLogin();
        if(!$result){
            $_SESSION['msg'] = 'ユーザを登録してログインしてください';
            return $this->render([
                'title' => 'マイページ',
                'msg' => $_SESSION['msg'],
                'result' => $result
            ],'mypage_form');
    

        }else{
            $login_user = $_SESSION['login_user'];
            return $this->render([
                'title' => 'マイページ',
                'login_user' => $login_user,
                'result' => $result
            ],'mypage_form');
    
        }

    }


    public function delete()
    {

        session_start();
        $login_user = $_SESSION['login_user'];
        $user_id = $login_user['userid'];

        $result = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $result = $this->user_logic->deleteUser($user_id);

        }

        return $this->render([
            'title' => '削除',
            'login_user' => $login_user,
            'result' => $result
        ],'delete_users_page');

    }


}

