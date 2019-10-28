<?php

namespace api\modules\v1\controllers;

use api\modules\v1\resources\Article;
use api\modules\v1\resources\Request;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\rest\IndexAction;
use yii\rest\OptionsAction;
use yii\rest\CreateAction;
use yii\rest\UpdateAction;
use yii\rest\DeleteAction;
use yii\rest\Serializer;
use yii\rest\ViewAction;
use yii\web\HttpException;

/**

 * @author Eugene Terentev <eugene@terentev.net>
 */
class RequestController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'api\modules\v1\resources\Request';

    /**
     * @SWG\Get(path="/v1/request/index",
     *     tags={"request", "index"},
     *     summary="Retrieves the collection of Articles.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Article collection response",
     *         @SWG\Schema(ref = "#/definitions/Request")
     *     ),
     * )
     *
     * @SWG\Get(path="/v1/request/view",
     *     tags={"Request"},
     *     summary="Displays data of one article only",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Used to fetch information of a specific article.",
     *         @SWG\Schema(ref = "#/definitions/Request")
     *     ),
     * )
     *

     */
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProvider']
            ],
            'view' => [
                'class' => ViewAction::class,
                'modelClass' => $this->modelClass,
                'findModel' => [$this, 'findModel']
            ],
            'options' => [
                'class' => OptionsAction::class,

            ]
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        return new ActiveDataProvider(array(
            'query' => Request::find()->with('category')
        ));
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $model = \common\models\Request::find()
            ->andWhere(['id' => (int)$id])
//            ->joinWith('category')
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
    }
}
