<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Videos;
use yii\data\ActiveDataProvider;

class AkeyYouTubeController extends Controller
{
    // google-site-verification=Bl_zo9D_POmh3_kjWH1reRAen1DytEQHt131EdyDSzk
    // AIzaSyDwnGPGC8AqG_qQgrRNqrHLTVrtQhSS6Z4

    public $id;
    private $apiKey = 'AIzaSyDwnGPGC8AqG_qQgrRNqrHLTVrtQhSS6Z4';
    private $youtube;

    public function __construct(){
        // $client = new Google_Client();
        $client = \Yii::$app->googleApi->googleClient;
        $client->setDeveloperKey($this->apiKey);
        $this->youtube = new Google_Service_YouTube($client);
    }

    public function videosByIds( string $ids){
        return $this->youtube->videos->listVideos('snippet, statistics, contentDetails', [
            'id' => $ids,
        ]);
    }

    public function videos(int $maxResults=10, string $region='RU'){
        return $this->youtube->videos->listVideos('snippet, statistics, contentDetails', [
            'chart' => 'mostPopular',
            'maxResults' => $maxResults,
            'regionCode' => $region,
        ]);
    }

    public function search(string $q, int $maxResults=12, string $lang='ru' ){
        $response = $this->youtube->search->listSearch('snippet',
            array(
                'q' => $q,
                'maxResults' => $maxResults,
                'relevanceLanguage' => $lang,
                'type' => 'video'
            ));
        return $response;
    }

    public function getCategory($regionCode = 'RU'){
        $result = $this->youtube->videoCategories->listVideoCategories('snippet',
            array('hl' => 'ru', 'regionCode' => $regionCode));
        $category = [];
        $array = $result->getItems();

        array_walk($array, function ($value) use (&$category){
            $category[$value['id']] =  $value['snippet']['title'];
        });

        return $category;
    }

    public function getPopularVideosByCategory( string $videoCategoryId, int $maxResults=10, string $region='RU', $pageToken=null){
        try {
            $response = $this->youtube->videos->listVideos('snippet, statistics, contentDetails',
                array('videoCategoryId' => $videoCategoryId,
                    'maxResults' => $maxResults,
                    'regionCode' => $region,
                    'chart' => 'mostPopular',
                    'pageToken' => $pageToken,
                ));

        } catch (\Google_Service_Exception $e){
            return false;
        }
        return $response;
    }
}

?>