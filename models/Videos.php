<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%videos}}".
 *
 * @property int $id
 * @property string $channel_title
 * @property string $video_title
 * @property string $video_description
 * @property string $video_thumbnail
 * @property string $youtube_video_id
 */
class Videos extends \yii\db\ActiveRecord
{

    public function getVideos(){
        return $this->hasOne(Videos::className(), ['id' => 'video_id']);
    }
    public function getVideoinfo(){
        return $this->hasMany(Videoinfo::className(), ['video_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%videos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['youtube_video_id'], 'required'],
            [['video_description'], 'string'],
            [['channel_title', 'video_title', 'video_thumbnail', 'youtube_video_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_title' => 'Channel Title',
            'video_title' => 'Video Title',
            'video_description' => 'Video Description',
            'video_thumbnail' => 'Video Thumbnail',
            'youtube_video_id' => 'Youtube Video ID',
        ];
    }

    public function getYouTubeVideoByHash($videoYouTubeHash){
        $googleClient = \Yii::$app->googleApi->googleClient;
        $youTube = new \Google_Service_YouTube($googleClient);
        $videoYoutubeInfo = $youTube->videos->listVideos('snippet, statistics, contentDetails', [
            'id' => $videoYouTubeHash,
        ]);
        $channelId = $videoYoutubeInfo->items[0]->snippet->channelId;
        $queryParams = [
            'id' => $channelId,
        ];
        $responseSubscribers = $youTube->channels->listChannels('snippet,contentDetails,statistics', $queryParams);
        $videoYoutubeInfo->items[0]->statistics->subscriberCount = $responseSubscribers->items[0]->statistics->subscriberCount;
        return $videoYoutubeInfo;
    }

    public function updateAllVideoInfo(){
        $allVideosQuery = Videos::find()->select(['id', 'youtube_video_id'])->all();
        foreach ($allVideosQuery as $video) {
            $videoId = $video->getId();
            $youtubeVideoId = $video->youTubeVideoId();
            $allVideoYoutubeInfo = Videos::getYouTubeVideoByHash($youtubeVideoId);
            $videoYouTubeStatistic = $allVideoYoutubeInfo->items[0]->statistics;
            $data = array(
                'video_id'          => $videoId,
                'views_count'       => $videoYouTubeStatistic->viewCount,
                'comments_count'    => $videoYouTubeStatistic->commentCount,
                'likes_count'       => $videoYouTubeStatistic->likeCount,
                'dislikes_count'    => $videoYouTubeStatistic->dislikeCount,
                'subscribes_count'  => $videoYouTubeStatistic->subscriberCount,
            );
            Yii::$app->db->createCommand("INSERT INTO akey_videoinfo (video_id, views_count, comments_count, likes_count, dislikes_count, subscribes_count) VALUES (".$data['video_id'].", ".$data['views_count'].", ".$data['comments_count'].", ".$data['likes_count'].", ".$data['dislikes_count'].", ".$data['subscribes_count'].")")->execute();
        }
    }
    public function getId(){
        return $this->id;
    }
    public function youTubeVideoId(){
        return $this->youtube_video_id;
    }

}
// HOME=/var/www/dev4.anikeyeu.com/public_html/basic
// /5 * * * * php $HOME/models Videos/updateAllVideoInfo
