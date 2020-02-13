<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Videoinfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="videoinfo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'video_id')->textInput() ?>

    <?= $form->field($model, 'views_count')->textInput() ?>

    <?= $form->field($model, 'comments_count')->textInput() ?>

    <?= $form->field($model, 'likes_count')->textInput() ?>

    <?= $form->field($model, 'dislikes_count')->textInput() ?>

    <?= $form->field($model, 'subscribes_count')->textInput() ?>

    <?= $form->field($model, 'date_and_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
