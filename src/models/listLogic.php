<?php


require_once '../func.php';

class listLogic
{

    public PDO $pdo;

    public function __construct()
    {
        $db = new setupDB();
        $this->pdo = $db->pdo;
    }


    public function validateRecord($records) :array
    {
        $err = [];
        // バリデーション
        if(!$records['date'] = filter_input(INPUT_POST, 'date')) {
            $err[] = '日付を記入してください';
        }
        if(!$records['name'] = filter_input(INPUT_POST, 'name')) {
            $err[] = 'トレーニング名を記入してください';
        }
        if(!$records['weight'] = filter_input(INPUT_POST, 'weight')) {
           
                
                $err[] = '重さを記入してください';
            
        }
        if(!$records['rep'] = filter_input(INPUT_POST, 'rep')) {
                $err[] = '回数を記入してください';
        }

        if(!preg_match('/\d+/', $records['weight'])){
            $err[] = '半角数字で入力してください。';
        }

        if(!preg_match('/\d+/', $records['rep'])){
            $err[] = '半角数字で入力してください。';
        }

        return $err;
    }


    public function selectTable($user_id)
    {
        //try-catch
        $sql = <<< SQL
                SELECT
                    fitness_record.id,
                    fitness_record.training_day,
                    fitness_record.training_name,
                    fitness_record.weight_score,
                    fitness_record.count
                FROM
                fitness_record 
                LEFT OUTER JOIN users
                ON fitness_record.userid = users.userid
                WHERE fitness_record.userid = :user_id
                ORDER BY 
                fitness_record.training_day
            SQL;


            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;
    }

    
    public function recordTable(array $records ,$user_id) :bool
    {

    $sql = <<<SQL
            INSERT INTO 
            fitness_record (userid,training_day, training_name , weight_score, count) 
            VALUES 
            (:userid,:training_day, :training_name , :weight_score, :count);
    SQL;
            $stmt = $this->pdo->prepare($sql); //値が空のままSQL文をセット
            $params = array(':userid' => $user_id,':training_day' => $records['date'], ':training_name' => $records['name'], ':weight_score' => $records['weight'],':count' => $records['count']); // 挿入する値を配列に格納
            $result = $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
            
            return $result;
            
    }


    public function updateTable($id,array $updateRecords) :bool
    {

    try {

        $sql = <<< SQL
            UPDATE 
                fitness_record 
            SET 
                training_day = :training_day,
                training_name = :training_name , 
                weight_score = :weight_score, 
                count = :count
            WHERE
                id = :id
            
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $params = array(':id' => $id,':training_day' => $updateRecords['date'], ':training_name' => $updateRecords['name'], ':weight_score' => $updateRecords['weight'],':count' => $updateRecords['count']); // 挿入する値を配列に格納
        $result = $stmt->execute($params); 
        return $result;
        
       
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}


    public function deleteTable($id) :bool
    {

    try {

        $sql = <<< SQL
            DELETE 
            FROM fitness_record 
            WHERE id = :id
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $result = $stmt->execute();
        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}


}