<?php


require_once __DIR__ . '/../func.php';


class SignupController extends Controller
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

        $err =[];
        $err [] = $_SESSION;


        return $this->render([
            'csrf_token' => $csrf_token,
            'error' => $err
        ],'signup_form');
        

    }

    public function register()
    {
        session_start();


        $token = filter_input(INPUT_POST, 'csrf_token');
        //トークンがない、もしくは一致しない場合、処理を中止
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        exit('不正なリクエスト');
        }

        unset($_SESSION['csrf_token']);


        $usersData = [
            'user_id' => h($_POST['userid']),
            'mail' => h($_POST['mail']),
            'pass' => password_hash(h($_POST['pass']), PASSWORD_DEFAULT),
            'confirmpass' => password_hash(h($_POST['confirmpass']), PASSWORD_DEFAULT),
        ];
        
        // $err = [];
        $err = $this->user_logic->validateUsers($usersData);
        $result = $this->user_logic->checkDuplicate($usersData);

        if($result === false){
            $err [] ='このユーザーIDは既に使われております。。もう一度やり直してください。';
        }
            
            if(count($err) === 0){
                //ユーザを登録する処理
                $hasCreated = $this->user_logic->createUser($usersData);
                
                if(!$hasCreated){
                    $err[] = '登録に失敗しました';
                }
            }
            
            
        return $this->render([
            'error' => $err
        ],'signedup');


    }
}