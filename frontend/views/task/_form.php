<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\tables\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->widget(DateTimePicker::className(),[
        'name' => 'dp_1',
        'type' => DateTimePicker::TYPE_INPUT,
        'options' => ['placeholder' => 'Ввод даты/времени...'],
        'convertFormat' => true,
        'value'=> date("d.m.Y h:i",(integer) $model->date),
        'pluginOptions' => [
            'format' => 'yyyy-MM-dd HH:mm:ss',
            'autoclose'=>true,
            'weekStart'=>1,
            'startDate' => '2015-05-01 00:00:00',
            'todayBtn'=>true,
        ]
    ]) ?>

    <?= $form->field($model, 'description')->textArea() ?>

    <?= $form->field($model, 'responsible_id')->dropDownList($usersList) ?>

    <?= $form->field($model, 'id_status')->dropDownList($statusList) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
