<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Log | Record </title>
</head>
<body>

    <h1>
        <a href="/">
            fitness log
        </a>
    </h1>

    <ul>
        <li>
            <a href="/record/create">トレーニングを記録する</a>

        </li>
        <li>
            <a href="/record">トレーニング一覧</a>

        </li>
        <li>
            <a href="/mypage">マイページ</a>

        </li>
    </ul>


    <form action="/record/register" method="POST">


        <div>
            
                    <label for="date">Date</label>
                    <input type="date" name="date">
                    <?php if(isset($err['date'])):?>
                        <p> <?php echo $err['date']?></p>
                    <?php endif;?>

        </div>

        <div>

            <label for="name">Training</label>
            <input type="text" name="name">
            <?php if(isset($err['name'])):?>
                        <p> <?php echo $err['name']?></p>
                    <?php endif;?>
        </div>

        <div>
            <label for="weight">Weight</label>
            <input type="text" name="weight">
            <?php if(isset($err['weight'])):?>
                        <p> <?php echo $err['weight']?></p>
            <?php endif;?>
           

        </div>
        
        <div>

            <label for="rep">Rep</label>
            <input type="number" name="rep">
            <?php if(isset($err['rep'])):?>
                        <p> <?php echo $err['rep']?></p>
                    <?php endif;?>
           
        </div>

        <input type="hidden" name="csrf_token" value="<?php echo h($csrf_token); ?>" />
       

        <input type="submit">

    </form>

    
    
</body>
</html>