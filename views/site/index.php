<?php
use app\models\Videos;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */

$this->title = 'YouTube Video Info';

?>
<div class="site-index">
    <div class="body-content">
        <?php
            echo ListView::widget([
                'dataProvider' => $listDataProvider,
                'itemView' => '_list',
                'options' => [
                    'tag' => 'div',
                    'class' => 'news-list',
                    'id' => 'news-list',
                ],
                
                'layout' => "{pager}\n{summary}\n{items}\n{pager}",
                'summaryOptions' => [
                    'tag' => 'span',
                    'class' => 'my-summary'
                ],
             
                'itemOptions' => [
                    'tag' => 'div',
                    'class' => 'news-item',
                ],
             
                'emptyText' => '<p>List is empty</p>',
                'emptyTextOptions' => [
                    'tag' => 'p'
                ],
             
                'pager' => [
                    'firstPageLabel' => 'First',
                    'lastPageLabel' => 'Last',
                    'nextPageLabel' => 'Next',
                    'prevPageLabel' => 'Prev',        
                    'maxButtonCount' => 5,
                ],
            ]);
        ?>
    </div>
</div>
