
<?php if (count($error)):?>
    <?php foreach ($error as $e) :?>
        <p><?php echo $e ?></p>
    <?php endforeach ;?>
        <p>もう１度やり直してください。</p>
<?php endif; ?>


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
