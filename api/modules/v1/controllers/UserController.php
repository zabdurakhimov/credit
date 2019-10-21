<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\LoginFormAPI;
use common\models\User;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\rest\OptionsAction;
use yii\rest\ViewAction;
use yii\web\HttpException;
use yii\web\Response;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class UserController extends Controller
{

    /**
     * @var string
     */
    public $modelClass = 'api\modules\v1\resources\User';

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'view' => [
                'class' => ViewAction::class,
                'modelClass' => $this->modelClass,
                'findModel' => [$this, 'findModel']
            ],
            'options' => [
                'class' => OptionsAction::class
            ]
        ];
    }

    /**
     * @return User|null|\yii\web\IdentityInterface
     */
    public function actionIndex()
    {
        $resource = new User();
        $resource->load(\Yii::$app->user->getIdentity()->attributes, '');
        return $resource;
    }


    /**
     * User login
     */
    public function actionLogin()
    {
        /**
         * TODO: assign user_id by ud_id in cart table
         */
        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = Yii::$app->getRequest()->getBodyParams();

        Yii::$app->language = "ru";
        if (isset($data['lang'])) {
            $lang = $data['lang'];
            if (in_array($lang, ["ru", "uz"])) {
                Yii::$app->language = $lang;
            }
        }

        $model = new LoginFormApi();

        if (!$model->load($data, '')) {
            $errors = $model->reformatErrors();
            return ['error' => 2, 'message' => 'Could not load data.', 'result' => $errors];
        }

        if (!$model->validate()) {
            $errors = $model->reformatErrors();
            return ['error' => 1, 'message' => 'Validation errors.', 'result' => $errors];
        }

        if ($model->login()) {
            $token = $model->user->access_token;
            $name = $model->user->username;
            return ['error' => 0, 'message' => 'success', 'result' => ['access_token' => $token, 'name' => $name, ]];
        } else {
            $errors = $model->reformatErrors();
            return ['error' => 3, 'message' => 'Could not login.', 'result' => $errors];
        }
    }



    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $model = User::find()
            ->joinWith('userProfile', true)
            ->active()
            ->andWhere(['user.id' => (int)$id])
            ->asArray()
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
    }
}
