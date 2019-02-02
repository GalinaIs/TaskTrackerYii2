<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use frontend\assets\OneTaskAsset;

OneTaskAsset::register($this);
?>

<h2><?=$labelPage->nameLabel ?><?= $model->name ?></h2>
<p><?= $labelPage->descriptionLabel ?><?= $model->description ?></p>
<div><?= $labelPage->dateLabel ?><?= $model->date ?></div>
<div><?= $labelPage->responsibleLabel ?><?= $model->user->name ?></div>
<div><?= $labelPage->statusLabel ?><?= $model->status->name ?></div>

<?= Html::beginForm(['task/update', 'id' => $model->id]) ?>
    <?= Html::submitButton($labelPage->buttonChange, ['class' => 'btn btn-warning create_task_button']) ?>
<?= Html::endForm() ?>

<?php if($user_id && !\Yii::$app->user->can('CommentAddDenied')): ?>
<h4><?= $labelPage->addCommentLabel ?></h4>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($modelComment, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($modelComment, 'content')->textArea() ?>

<?= $form->field($modelComment, 'img_path')->fileInput() ?>

<?= Html::submitButton('Оставить комментарий', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>
<?php else: ?>
<h4><?= $labelPage->commentLoginLabel ?></h4>
<?php endif; ?>

<h4><?= $labelPage->commentsTaskLabel ?></h4>
<?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_list',
        'options' => [
            'class' => 'view_comments'
        ],
        'summary' => false,
        'emptyText' => 'Нет комментариев',
        'viewParams' => [
            'userLabel' => $labelPage->userLabel,
            'nameCommentLabel' => $labelPage->nameCommentLabel,
            'commentLabel' => $labelPage->commentLabel
        ]
    ]);
?>