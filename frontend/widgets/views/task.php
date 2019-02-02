<?php
use yii\helpers\Url;
?>

<div class='tasks-item bg-success text-center'>
    <a href=<?= Url::to(['task/item', 'id' => $id]) ?> class='text-success font-italic'>
        <h2><?= $title ?></h2>    
        <p><?= $description ?></p>
        <div class="one_preview_task">
            <div><?= $user ?></div>
            <div><?= $date ?></div>
        </div>
    </a> 
</div>