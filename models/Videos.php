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

    public function getYouTubeVideoByHash($videoYouTubeHash){
        $googleClient = \Yii::$app->googleApi->googleClient;
        $youTube = new \Google_Service_YouTube($googleClient);
        $videoYoutubeInfo = $youTube->videos->listVideos('snippet, statistics, contentDetails', [
            'id' => $videoYouTubeHash,
        ]);
        return $videoYoutubeInfo;
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
            [['channel_title', 'video_title', 'video_description', 'video_thumbnail', 'youtube_video_id'], 'required'],
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

}
