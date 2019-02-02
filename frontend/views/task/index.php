<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\widgets\Pjax;
use frontend\assets\TasksAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks Tracker';
$this->params['breadcrumbs'][] = $this->title;
TasksAsset::register($this);
?>
<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Выберите период, за который хотите просмотреть задачи:</p>
    <?php $form1 = ActiveForm::begin() ?>
        <?= $form1->field($dateModel, 'dateBegin')->widget(DateTimePicker::className(),[
            'type' => DateTimePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Выберите начало периода'],
            'convertFormat' => true,
            'value'=> date("d.m.Y",(integer) $dateModel->dateBegin),
            'pluginOptions' => [
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'autoclose'=>true,
                'weekStart'=>1,
                'startDate' => '2015-05-01 00:00:00',
                'todayBtn'=>true,
            ]
        ]) ?>
        <?= $form1->field($dateModel, 'dateEnd')->widget(DateTimePicker::className(),[
            'type' => DateTimePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Выберите конец периода'],
            'convertFormat' => true,
            'value'=> date("d.m.Y",(integer) $dateModel->dateEnd),
            'pluginOptions' => [
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'autoclose'=>true,
                'weekStart'=>1,
                'startDate' => '2015-05-01 00:00:00',
                'todayBtn'=>true,
            ]
        ])  ?>
        <?= Html::submitButton('Показать задачи', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>

    <?php Pjax::begin(); ?>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => 'view',
            'options' => [
                'class' => 'preview_tasks'
            ],
        ]); 
        
        ?>
    <?php Pjax::end(); ?>

    <?= Html::beginForm(Url::to(['task/create'])) ?>
        <?= Html::submitButton('Создать новую задачу', ['class' => 'btn btn-warning create_task_button']) ?>
    <?= Html::endForm() ?>
</div>
