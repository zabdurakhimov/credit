<?php

namespace common\models;

use cheatsheet\Time;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $identity;
    public $password;
    public $rememberMe = true;

    protected $user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['identity', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'identity' => Yii::t('frontend', 'Username or email'),
            'password' => Yii::t('frontend', 'Password'),
            'rememberMe' => Yii::t('frontend', 'Remember Me'),
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('frontend', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        $pattern = '/^\+998\(((90|91|93|94|95|97|98|99))\)-?[0-9]{3}-?[0-9]{2}-?[0-9]{2}$/';
        $phone = $this->identity;

        if (preg_match($pattern, $phone)) {
            $phone =  "+".preg_replace('/\D/', '', $this->identity);
        }

        if ($this->user === false) {
            $this->user = User::find()
                ->active()
                ->andWhere(['or', ['phone_number' => $phone], ['email' => $this->identity]])
                ->one();
        }

        return $this->user;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? Time::SECONDS_IN_A_MONTH : 0)) {
                $this->attachUserByUid();

                return true;
            }
        }
        return false;
    }

    public function attachUserByUid()
    {

    }

    public function getUid()
    {
        if (isset($_COOKIE["uid"])) {
            return $_COOKIE["uid"];
        }
    }

    public function clearUidCookie()
    {
        unset($_COOKIE['uid']);
        setcookie('uid', null, -1, "/");
    }
}