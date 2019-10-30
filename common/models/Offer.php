<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "offer".
 *
 * @property int $id
 * @property double $initial_pay
 * @property double $total_pay
 * @property int $period
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 *
 * @property User $createdBy
 * @property Request[] $requests
 * @property Response[] $responses
 */
class Offer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['initial_pay', 'total_pay', 'period'], 'required'],
            ['created_at', 'default', 'value' => time()],
            ['updated_at', 'default', 'value' => time()],
            ['created_by', 'default', 'value' => \Yii::$app->user->identity->primaryKey],
            [['initial_pay', 'total_pay'], 'number'],
            [['period', 'created_at', 'updated_at', 'created_by'], 'default', 'value' => null],
            [['period', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'initial_pay' => 'Initial Pay',
            'total_pay' => 'Total Pay',
            'period' => 'Period',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['offer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['offer_id' => 'id']);
    }
}
