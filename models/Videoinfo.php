<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%videoinfo}}".
 * 
 * @property int $id
 * @property int $video_id
 * @property int $views_count
 * @property int $comments_count
 * @property int $likes_count
 * @property int $dislikes_count
 * @property int $subscribes_count
 * @property string $date_and_time
 */
class Videoinfo extends \yii\db\ActiveRecord
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
        return '{{%videoinfo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'views_count', 'comments_count', 'likes_count', 'dislikes_count', 'subscribes_count', 'date_and_time'], 'required'],
            [['video_id', 'views_count', 'comments_count', 'likes_count', 'dislikes_count', 'subscribes_count'], 'integer'],
            [['date_and_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video_id' => 'Video ID',
            'views_count' => 'Views Count',
            'comments_count' => 'Comments Count',
            'likes_count' => 'Likes Count',
            'dislikes_count' => 'Dislikes Count',
            'subscribes_count' => 'Subscribes Count',
            'date_and_time' => 'Date And Time',
        ];
    }
    public function getId(){
        return $this->id;
    }
    public function getViewsCount(){
        return $this->views_count;
    }
    public function getCommentsCount(){
        return $this->comments_count;
    }
    public function getLikesCount(){
        return $this->likes_count;
    }
    public function getDislikesCount(){
        return $this->dislikes_count;
    }
    public function getSubscribersCount(){
        return $this->subscribes_count;
    }
    public function getDateAndTime(){
        return $this->date_and_time;
    }
}
