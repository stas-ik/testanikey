<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Videoinfos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videoinfo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Videoinfo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'video_id',
            'views_count',
            'comments_count',
            'likes_count',
            //'dislikes_count',
            //'subscribes_count',
            //'date_and_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
