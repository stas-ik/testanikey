<?php

namespace app\controllers;

use Yii;
use app\models\Videoinfo;
use app\models\Videos;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VideoinfoController implements the CRUD actions for Videoinfo model.
 */
class VideoinfoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Videoinfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Videoinfo::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Videoinfo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Videoinfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Videoinfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function createInfoFromYoutube($videoId, $youtubeVideoId){
        $allVideoYoutubeInfo = Videos::getYouTubeVideoByHash($youtubeVideoId);
        $channelId = $allVideoYoutubeInfo->items[0]->snippet->channelId;
        $videoYouTubeStatistic = $allVideoYoutubeInfo->items[0]->statistics;
        $data = array(
            'video_id'          => $videoId,
            'views_count'       => $videoYouTubeStatistic->viewCount,
            'comments_count'    => $videoYouTubeStatistic->commentCount,
            'likes_count'       => $videoYouTubeStatistic->likeCount,
            'dislikes_count'    => $videoYouTubeStatistic->dislikeCount,
            'subscribes_count'  => 0,
        );
        if(Yii::$app->db->createCommand("INSERT INTO akey_videoinfo (video_id, views_count, comments_count, likes_count, dislikes_count, subscribes_count) VALUES (".$data['video_id'].", ".$data['views_count'].", ".$data['comments_count'].", ".$data['likes_count'].", ".$data['dislikes_count'].", ".$data['subscribes_count'].")")->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Updates an existing Videoinfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Videoinfo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Videoinfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Videoinfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Videoinfo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
