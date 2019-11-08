<?php

namespace api\modules\v1\controllers;

use api\modules\v1\resources\Request;
use common\models\Category;
use common\models\RequestFavorite;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\{CompositeAuth, QueryParamAuth, HttpBasicAuth, HttpBearerAuth, HttpHeaderAuth};
use yii\rest\ActiveController;
use yii\rest\ {IndexAction, OptionsAction, CreateAction, ViewAction, DeleteAction};
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
     *
     *   * * * @SWG\Get(path="/v1/request/my-posts",
     *     tags={"Get Request list by created by current user"},
     *     summary="Get Request list by created by current user",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Get Request list created by current user",
     *     ),
     * )
     *
     * *   * * * @SWG\Get(path="/v1/request/favorite",
     *     tags={"Get Request list by starred by current user"},
     *     summary="Get Request list starred by current user",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Get Request list starred by current user",
     *     ),
     * )
     *
     *     @SWG\Get(path="/v1/request/delete-from-favorite",
     *     tags={"Removes a request from favorite, param: request_id"},
     *     summary="Removes a request from favorite, param: request_id",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Removes a request from favorite, param: request_id",
     *     ),
     * )
     *
     *
     * * * @SWG\Post  (path="/v1/request/add-to-favorite",
     *     tags={"Ad  To Favorite", "add-to-favorite"},
     *     summary="Makes a request favorite.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Request collection response",
     *         @SWG\Schema(ref = "#/definitions/Request")
     *     ),
     * )
     *
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
            'add-to-favorite' => [
                'class' => CreateAction::class,
                'modelClass' => RequestFavorite::class,
            ],
            'view' => [
                'class' => ViewAction::class,
                'modelClass' => $this->modelClass,
                'findModel' => [$this, 'findModel']
            ],
            'delete-from-favorite' => [
                'class' => DeleteAction::class,
                'modelClass' => RequestFavorite::class,
                'findModel' => [$this, 'findFavorite']
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


    public function findFavorite($id)
    {
        $model = \common\models\RequestFavorite::find()
            ->andWhere(['request_id' => (int)$id])
            ->andWhere(['created_by' => Yii::$app->user->identity->id])
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
    public function actionMyPosts(){
        return new ActiveDataProvider(array(
            'query' => Request::find()->where(['created_by' => Yii::$app->user->identity->id])->with('category')
        ));
    }

    public function actionFavorite(){
        return new ActiveDataProvider(array(
            'query' => Request::find()->joinWith('favorite')->where(['request_favorite.created_by' => Yii::$app->user->identity->id])
        ));
    }
}
