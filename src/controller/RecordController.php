<?php 


// require_once __DIR__ . '/../models/classes/listLogic.php';
// require_once '../func.php';


class RecordController extends Controller
{
    private $recordLogic;
    private array $err = [];
    public function __construct()
    {
        $this->recordLogic = new listLogic();
    }

    public function index()
    {
        if (session_status() == PHP_SESSION_NONE) {
            // セッションは有効で、開始していないとき
            session_start();
        }
        if(!isset($_SESSION['login_user'])){
            $_SESSION['msg'] = 'ログインもしくは会員登録をしてください';
            header('Location:/');
            exit;

        }else{
            $login_user = $_SESSION['login_user'];
            $user_id = $login_user['userid'];
            $results = $this->recordLogic->selectTable($user_id); 
        
            return $this->render([
                'title' => 'トレーニングリスト',
                'results' => $results,
        ],'recordlist');


        }

    }

    public function create()
    {

        if (session_status() == PHP_SESSION_NONE) {
            // セッションは有効で、開始していないとき
            session_start();
        }

        $csrf_token = Token();
        
        if(!isset($_SESSION['login_user'])){
            $_SESSION['msg'] = 'ログインもしくは会員登録をしてください';
            header('Location:/');
            exit;
            }else{
                return $this->render([
                    'title' => 'トレーニングレコード',
                    'error' => $this->err,
                    'csrf_token' => $csrf_token,
                    
            ],'record_form');
        }
    }


    public function register()
    {
        session_start();

        $token = filter_input(INPUT_POST, 'csrf_token');

        if (!isset($_POST['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            // トークンが一致しなかった場合
            die('不正なリクエストです。');
        }
        unset($_SESSION['csrf_token']);

    
        $login_user = $_SESSION['login_user'];
        $user_id = $login_user['userid'];
    
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $records = [
                'date' => h($_POST['date']),
                'name' => h($_POST['name']),
                'weight' => h($_POST['weight']),
                'count' => h($_POST['rep']),
            ];
                $this->err = $this->recordLogic->validateRecord($records);
            if (count($this->err) > 0) {
                return $this->render([
                    'title' => 'トレーニングレコード',
                    'error' => $this->err
            ],'record_form');

            }
    
            $result = $this->recordLogic->recordTable($records,$user_id); 
            if ($result == true){
                return $this->index();
            }else{
                $this->err[] ='レコード処理に失敗しました。' ;
                return $this->render([
                    'title' => 'トレーニングレコード',
                    'error' => $this->err
            ],'record_form');

            }
        }

    }

    public function edit()
    {
        session_start();
        if(!isset($_SESSION['login_user'])){
            return $this->create();
            
        }
        $csrf_token = Token();
        $id = $_POST['id'];

        return $this->render([
            'title' => '編集',
            'id' => $id,
            'csrf_token' => $csrf_token,
            ],'edit_form');
        
    }

    public function update()
    {
        session_start();

        $token = filter_input(INPUT_POST, 'csrf_token');

        if (!isset($_POST['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            // トークンが一致しなかった場合
            die('不正なリクエストです。');
        }
        
        unset($_SESSION['csrf_token']);


        $id = $_POST['id'];

        if($_SERVER["REQUEST_METHOD"] == "POST"){
        $updateRecords = [
            'date' => h($_POST['date']),
            'name' => h($_POST['name']),
            'weight' => h($_POST['weight']),
            'count' => h($_POST['rep']),
        ];

        
        $this->err = $this->recordLogic->validateRecord($updateRecords);
        if (count($this->err) > 0) {
            return $this->update();

        }else{
            
            $result = $this->recordLogic->updateTable($id,$updateRecords);

        }
    }

        if ($result == true){
            return $this->index();
        }

    }

    public function delete()
    {
        $id = $_POST['id'];
        $result = $this->recordLogic->deleteTable($id);

        if ($result == true){
            return $this->index();

    }

    }

}