<?php
use app\controllers\VideoinfoController;
use app\models\Videos;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="item_video mb50 pb50">
    <?php
    	$date_arr 		= array();
    	$views 			= array();
    	$comments		= array();
    	$likes 			= array();
    	$dislikes 		= array();
    	$subscribers 	= array();
    	foreach ($model->videoinfo as $video_info) {
	    	$date_arr[] 	= date('d.m.Y H:i', strtotime($video_info->getDateAndTime()));
	    	$views[] 		= $video_info->getViewsCount();
	    	$comments[] 	= $video_info->getCommentsCount();
	    	$likes[] 		= $video_info->getLikesCount();
	    	$dislikes[] 	= $video_info->getDislikesCount();
	    	$subscribers[]  = $video_info->getSubscribersCount();
    	}
		$allVideoYoutubeInfo = Videos::getYouTubeVideoByHash($model->youtube_video_id);
        $videoYoutubeInfo = $allVideoYoutubeInfo->items[0]->snippet;
        
        $update_video_info_text = VideoinfoController::createInfoFromYoutube($model->id, $model->youtube_video_id);

    ?>
    <pre><?php print_r($allVideoYoutubeInfo); ?></pre>
    <h2><?php echo $videoYoutubeInfo->title; ?></h2>
    <div class="row mb15">
	    <div class="col-lg-6">
	    	<div class="video_thumbnail"><img src="<?php echo $videoYoutubeInfo->thumbnails['high']['url']; ?>" alt="<?php echo $videoYoutubeInfo->title; ?>"></div>
	    </div>
	    <div class="col-lg-6">
	        <div class="chart_wrapper">
	            <?php
	                use miloschuman\highcharts\Highcharts;
	                echo Highcharts::widget([
	                   'options' => [
	                      'title' => ['text' => ''],
	                      'xAxis' => [
	                         'categories' => $date_arr,
	                      ],
	                      'yAxis' => [
	                         'title' => ['text' => 'Count']
	                      ],
	                      'series' => [
	                      	['name' => 'Views count', 'data' => $views],
	                      	['name' => 'Comments count', 'data' => $comments],
	                      	['name' => 'Likes count', 'data' => $likes],
	                      	['name' => 'Dislikes count', 'data' => $dislikes],
	                      	['name' => 'Subscribers count', 'data' => $subscribers],
	                      ]
	                   ]
	                ]);
	            ?>
	        </div>
	    </div>
    </div>
    <div class="video_info mb15">
        <div class="dflex inforow jcsb mb10">
        	<div class="like_a_label">Channel Title</div>
        	<div class="like_a_value"><?php echo $videoYoutubeInfo->channelTitle; ?></div>
        </div>
	</div>
    <div class="video_description_wrapper">
    	<h4>Description</h4>
		<div class="video_description mb15">
			<?php echo str_replace("\n", "<br>", $videoYoutubeInfo->description); ?>
		</div>
    </div>
</div>