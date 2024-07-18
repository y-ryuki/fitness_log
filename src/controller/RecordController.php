<?php 

require_once __DIR__ . '/../models/classes/listLogic.php';
require_once '../func.php';


class RecordController extends Controller
{
    private $recordLogic;
    public function __construct()
    {
        $this->recordLogic = new listLogic();
    }

    public function index()
    {
        session_start();

        $login_user = $_SESSION['login_user'];
        $user_id = $login_user['userid'];

        if(!isset($_SESSION['login_user'])){
            header('Location: /record/create');
        }

            
            
            $results = $this->recordLogic->selectTable($user_id);    

        include __DIR__ . '/../views/recordlist.php';
    }

    public function create()
    {
        session_start();

        $csrf_token = Token();

        $err =[];
        $err = $_SESSION;

        $login_user = $_SESSION['login_user'];
        $user_id = $login_user['userid'];


        if(!isset($_SESSION['login_user'])){
            header('Location: /record/create');
        }


        include __DIR__ . '/../views/record_form.php';
        
    }


    public function register()
    {
        session_start();

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            // トークンが一致しなかった場合
            die('不正なリクエストです。');
        }
    
        $login_user = $_SESSION['login_user'];
        $user_id = $login_user['userid'];
    
        
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $records = [
                'date' => h($_POST['date']),
                'name' => h($_POST['name']),
                'weight' => h($_POST['weight']),
                'count' => h($_POST['rep']),
            ];
    
            $err =[];
            
            $logic = new listLogic();
            $err = $logic->validateRecord($records);
            if (count($err) > 0) {
                // エラーがあった場合は戻す
                $_SESSION = $err;
                header('Location: /record/create');
                return;
            }
    
            $this->recordLogic->recordTable($records,$user_id); 
        }

    }

    public function edit()
    {
        session_start();
        if(!isset($_SESSION['login_user'])){
            header('Location: /record/create');
        }

        $csrf_token = Token();

        $err =[];
        $err = $_SESSION;

        $id = $_POST['id'];
        include __DIR__ . '/../views/edit_form.php';
    }

    public function update()
    {
        session_start();

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            // トークンが一致しなかった場合
            die('不正なリクエストです。');
        }

        $id = $_POST['id'];

        if($_SERVER["REQUEST_METHOD"] == "POST"){
        $updateRecords = [
            'date' => h($_POST['date']),
            'name' => h($_POST['name']),
            'weight' => h($_POST['weight']),
            'count' => h($_POST['rep']),
        ];

        $logic = new listLogic();
        $err = $this->recordLogic->validateRecord($updateRecords);
        if (count($err) > 0) {
            // エラーがあった場合は戻す
            $_SESSION = $err;
            header('Location: /record/create');
            return;
        }else{
            
            $this->recordLogic->updateTable($id,$updateRecords);
        }
        }
    }

    public function delete()
    {
        $id = $_POST['id'];
        $logic = new listLogic();
        $this->recordLogic->deleteTable($id);


    }



}