<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Videoinfo */

$this->title = 'Create Videoinfo';
$this->params['breadcrumbs'][] = ['label' => 'Videoinfos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videoinfo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
