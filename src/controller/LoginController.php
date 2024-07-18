<?php 

require_once __DIR__ . '/../models/classes/UserLogic.php';
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

        $result = UserLogic::checkLogin();
        if($result) {
            header('/mypage');
            return;
        }   

        $err = $_SESSION;
        include __DIR__ . '/../views/login_page.php';

    }

    public function login()
    {
        session_start();


        $token = filter_input(INPUT_POST, 'csrf_token');
        // トークンがない、もしくは一致しない場合、処理を中止
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            exit('不正なリクエスト');
        }

        unset($_SESSION['csrf_token']);


        $loginData = [
        'userid' => h($_POST['userid']),
        'password' => h($_POST['pass']),
        ];

        // エラーメッセージ
        $err = [];

        // バリデーション
        if(!$loginData['userid'] = filter_input(INPUT_POST, 'userid')) {
        $err['userid'] = 'ユーザーIDを記入してください。';
        }
        if(!$loginData['password'] = filter_input(INPUT_POST, 'pass')) {
        $err['password'] = 'パスワードを記入してください。';
        }

        if (count($err) > 0) {
        // エラーがあった場合は戻す
        $_SESSION = $err;
        header('Location:/');

        return;
        }

        // ログイン成功時の処理
        $result = $this->user_logic->login($loginData);
        
        header('Location:/mypage');
        
        // ログイン失敗時の処理
        if (!$result) {
        header('Location:/');
        return;
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

            include __DIR__ . '/../views/logout_form.php';

        }

    
    public function edit()
    {
        session_start();

        $csrf_token = Token();
    
        if(!isset($_SESSION['login_user'])){
            $_SESSION['err'] = 'ログインをもう一度やり直してください';
        }
    
        $err =[];
        $err = $_SESSION;
        
        $login_user = $_SESSION['login_user'];

        include __DIR__ .'/../views/edit_users_form.php';
    }

    
    public function update()
    {
        session_start();

        $login_user = $_SESSION['login_user'];

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            // トークンが一致しなかった場合
            die('不正なリクエストです。');
        }
        unset($_SESSION['csrf_token']);

        $current_userid = $login_user['userid'];


        if($_SERVER["REQUEST_METHOD"] == "POST"){
        $updateUsers = [
            'user_id' => h($_POST['userid']),
            'mail' => h($_POST['mail']),
            
        ];

        

        $err = $this->user_logic->validateUsers($updateUsers);
        $err = $this->user_logic->checkDuplicate($updateUsers);
        $err=[];
        if (count($err) > 0) {
            // エラーがあった場合は戻す
            $_SESSION = $err;
            header('Location:/mypage');
            return;
        }else{
            
            $this->user_logic->updateUser($updateUsers,$current_userid);
            
        }
        }
    }


    public function mypage()
    {
        session_start();

        $result = UserLogic::checkLogin();
        if(!$result){
            $_SESSION['msg'] = 'ユーザを登録してログインしてください';
        }else{

            $login_user = $_SESSION['login_user'];
        }
        include __DIR__ .'/../views/mypage_form.php';
    }

    public function delete()
    {

        session_start();
        $login_user = $_SESSION['login_user'];
        $user_id = $login_user['userid'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $result = $this->user_logic->deleteUser($user_id);

        }
        include __DIR__ . "/../views/delete_users_page.php";

    }


}

