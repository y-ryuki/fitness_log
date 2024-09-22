

    
    <ul>
        
    <?php if(count($results) === 0):?>
        <p><?php echo 'データがありません。'?></p>
    <?php endif;?>

    <?php foreach($results as $result):?>
        
            <li><?php echo $result["training_day"];?></li>
            <li><?php echo $result["training_name"];?></li>
            <li><?php echo $result["weight_score"];?></li>
            <li><?php echo $result["count"];?></li>

            <form action="/record/edit" method="POST">
                <input type="hidden" name ='id' value="<?php echo $result['id'];?>">
                <input type="submit" value="編集">
            </form>

            <!-- <a href="/record/edit/id=">編集</a> -->

            <form action="/record/delete" method="POST">
                <input type="hidden" name ='id' value="<?php echo $result['id'];?>">
                <input type="submit" value="削除">
            </form>

             
            
        <?php endforeach;?>
        
    </ul>

    