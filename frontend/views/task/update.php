<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<h2>При необходимости ниже можно исправить информацию о задаче: </h2>

<?= $this->render('_form', [
    'model' => $model,
    'usersList' => $usersList,
    'statusList' => $statusList
]) ?>

<?= Html::beginForm(['task/item', 'id' => $model->id]) ?>
    <?= Html::submitButton('Просмотреть задачу', ['class' => 'btn btn-warning create_task_button']) ?>
<?= Html::endForm() ?>

<?= Html::beginForm(Url::to(['task/index'])) ?>
    <?= Html::submitButton('Вернутся к списку всех задач', ['class' => 'btn btn-warning create_task_button']) ?>
<?= Html::endForm() ?>