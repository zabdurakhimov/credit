<?php

namespace backend\controllers;

use backend\models\search\TimelineEventSearch;
use common\models\Article;
use common\models\User;
use Yii;
use yii\web\Controller;

/**
 * Application timeline controller
 */
class TimelineEventController extends Controller
{
    public $layout = 'common';

    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$user = Article::find()
            ->joinWith('author', true)
            ->where(['user.id' => 1])
            ->asArray()
            ->one();
         echo (json_encode($user ) );die;*/

        $searchModel = new TimelineEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
