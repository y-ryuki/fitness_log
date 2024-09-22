<?php

class setupDB
{

    private $dbName;
    private $dbUser;
    private $dbPass;
    private $dsn;
    public $pdo;

    public function __construct()
    {

        $this->dbName = 'DB_FIT';
        $this->dbUser = 'USER_FIT';
        $this->dbPass = 'PASS_FIT';
        $this->dsn = 'mysql:host=db;dbname=' . $this->dbName;
        $this->pdo = $this->dbConnect();


        $this->createTable();
        $this->createUsersTable();
    }


    public function dbConnect() :PDO
    {
            try{
                $pdo = new PDO($this->dsn, $this->dbUser, $this->dbPass,[
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);
                
                
            }catch(PDOException $e){
                echo "データベースへの接続に失敗しました。" . $e->getMessage() . PHP_EOL;
                exit();
            }
            // echo 'データベースへの接続に成功しました。' .PHP_EOL;
            return $pdo;
        }



    public function createTable() :void
        {
        $sql = <<<SQL
       
        CREATE TABLE IF NOT EXISTS  fitness_record (
            id INTEGER AUTO_INCREMENT,
            userid VARCHAR(255) NOT NULL,
            training_day DATE,
            training_name VARCHAR(255),
            weight_score INTEGER,
            count INTEGER,
            PRIMARY KEY (id,training_name)
        )
        SQL;

        try {
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            exit('テーブルの初期化に失敗しました' . $e);
        }
        
        // echo 'テーブルを作成しました。' . PHP_EOL;
    }


    public function createUsersTable() :void
    {
    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER AUTO_INCREMENT,
        userid VARCHAR(255) NOT NULL UNIQUE,
        email VARCHAR(255),
        pass VARCHAR(255),
        PRIMARY KEY (id,userid)
    )
    SQL;
    
    try {
        $this->pdo->exec($sql);
    } catch (PDOException $e) {
        exit('ユーザーテーブルの初期化に失敗しました' . $e);
    }
    
}

    
    
    

}