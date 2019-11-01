<?php

namespace api\modules\v1\controllers;

use api\modules\v1\resources\Request;
use common\models\Category;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\{CompositeAuth, QueryParamAuth, HttpBasicAuth, HttpBearerAuth, HttpHeaderAuth};
use yii\rest\ActiveController;
use yii\rest\ {IndexAction, OptionsAction, CreateAction, ViewAction};
use yii\web\HttpException;
use yii\web\Response;

/**

 * @author Eugene Terentev <eugene@terentev.net>
 */
class RequestController extends ActiveController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'authMethods' => [
                HttpBasicAuth::class,
                HttpBearerAuth::class,
                HttpHeaderAuth::class,
                QueryParamAuth::class
            ]
        ];
        return $behaviors;
    }
    /**
     * @var string
     */
    public $modelClass = 'api\modules\v1\resources\Request';

    /**
     * @SWG\Get(path="/v1/request/index",
     *     tags={"List", "index"},
     *     summary="Retrieves the collection of Requests.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Article collection response",
     *         @SWG\Schema(ref = "#/definitions/Request")
     *     ),
     * )
     *
     * /**
     * @SWG\Get(path="/v1/request/my-requests",
     *     tags={"List", "my-requests"},
     *     summary="Retrieves the collection of my Requests.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Article collection response",
     *         @SWG\Schema(ref = "#/definitions/Request")
     *     ),
     * )
     *
     * * @SWG\Get(path="/v1/request/get-types",
     *     tags={"Get request types", "get-types"},
     *     summary="Retrieves the collection of Request types.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Request type collection response",
     *         @SWG\Schema(ref = "#/definitions/Request")
     *     ),
     * )
     *
     * * @SWG\Post  (path="/v1/request/create",
     *     tags={"Create", "create"},
     *     summary="Creates a new Request.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Request collection response",
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
     * * @SWG\Get(path="/v1/request/category-list",
     *     tags={"Get Category List"},
     *     summary="Displays all categories",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Displays all categories.",
     *     ),
     * )
     * * * @SWG\Get(path="/v1/request/list-by-category",
     *     tags={"Get Request list by category and/or type"},
     *     summary="Displays all requests with no params",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Displays all categories. Params -- type, category",
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
                'prepareDataProvider' => [$this, 'prepareDataProvider'],
            ],
            'index-fund' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProviderFund'],
            ],
            'my-requests' => [
                'class' => IndexAction::class,
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProviderMy'],
            ],
            'create' => [
                'class' => CreateAction::class,
                'modelClass' => $this->modelClass,
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
            'query' => Request::find()->where(['type' => Request::TYPE_LENDING])->with('category')
        ));
    }
    public function prepareDataProviderFund()
    {
        return new ActiveDataProvider(array(
            'query' => Request::find()->where(['type' => Request::TYPE_FUNDING])->with('category')
        ));
    }
    public function prepareDataProviderMy()
    {
        return new ActiveDataProvider(array(
            'query' => Request::find()->where(['created_by' => Yii::$app->user->identity->id])->with('category')
        ));
    }


    public function actionGetTypes(){
        return \common\models\Request::types();
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

    public function getList($type)
    {
        $model = \common\models\Request::find()
            ->andWhere(['type' => (int)$type])
//            ->joinWith('category')
            ->all();
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
    }

    public function actionCategoryList()
    {
        return Category::getCategoryList();
    }

    public function actionListByCategory($type = null, $category = null)
    {
        if($type !== null){
            $type = ['type' => $type];
        }else{
            $type = [];
        }
        if($category !== null){
            $category = ['category_id' => $category];
        }else{
            $category = [];
        }
        return new ActiveDataProvider(array(
            'query' => Request::find()->where(array_merge($type, $category))->with('category')
        ));
    }
}
