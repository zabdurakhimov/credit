<?php

namespace api\modules\v1\models;

use cheatsheet\Time;
use common\models\User;
use common\models\LoginForm;
use Yii;
use yii\base\Model;

class LoginFormAPI extends LoginForm
{
    public $phone_number;
    public $ud_id;
    public $password;

    public $user;

    public function rules()
    {
        return [
            // username and password are both required
            [['phone_number', 'password'], 'required'],
            // phone number format
//            [['phone_number'], 'match', 'pattern' => '/^\+998(90|91|93|94|95|97|98|99)[0-9]{7}$/'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            [['phone_number', 'password', 'ud_id'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone_number' => Yii::t('frontend', 'Phone number'),
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
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? Time::SECONDS_IN_A_MONTH : 0)) {
                $this->attachUserByUid();

                if ($this->user->access_token == null) {
                    $this->user->access_token = sha1(time() . $this->phone_number . env('TOKEN_SALT'));
                    $this->user->save();
                }

                return true;
            }
        }
        return false;
    }

    /**
     * Finds user by [[phone_number]]
     *
     * @return User|null
     */
    public function getUser()
    {
        $pattern = '/^\+998\(((90|91|93|94|95|97|98|99))\)-?[0-9]{3}-?[0-9]{2}-?[0-9]{2}$/';
        $phone = $this->phone_number;

        if (preg_match($pattern, $phone)) {
            $phone =  "+".preg_replace('/\D/', '', $this->identity);
        }

        if ($this->user == null) {
            $this->user = User::find()
                ->active()
                ->andWhere(['or', ['phone_number' => $phone]])
                ->one();
        }

        return $this->user;
    }

    public function reformatErrors()
    {
        $errors = $this->errors;
        $formattedErrors = [];
        foreach($errors as $key => $value) {
            $formattedErrors[$key] =  ($value[0]);
        }

        return $formattedErrors;
    }

    public function fields()
    {
        return [
            'phone_number' => 'phone_number',
            'password' => 'password',
            'ud_id' => 'ud_id',
        ];
    }
}