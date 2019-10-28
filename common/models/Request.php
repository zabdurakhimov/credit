<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property int $category_id
 * @property int $type
 * @property int $accepted_response_id
 * @property int $status
 * @property int $offer_id
 * @property string $description_short
 * @property string $description_long
 * @property int $created_by
 * @property int $created_at
 *
 * @property Category $category
 * @property Offer $offer
 * @property Response $acceptedResponse
 * @property User $createdBy
 * @property Response[] $responses
 */
class Request extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'type', 'accepted_response_id', 'status', 'offer_id', 'created_by', 'created_at'], 'default', 'value' => null],
            [['category_id', 'type', 'accepted_response_id', 'status', 'offer_id', 'created_by', 'created_at'], 'integer'],
            [['description_long'], 'string'],
            [['description_short'], 'string', 'max' => 256],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Offer::className(), 'targetAttribute' => ['offer_id' => 'id']],
            [['accepted_response_id'], 'exist', 'skipOnError' => true, 'targetClass' => Response::className(), 'targetAttribute' => ['accepted_response_id' => 'id']],
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
            'category_id' => 'Category ID',
            'type' => 'Type',
            'accepted_response_id' => 'Accepted Response ID',
            'status' => 'Status',
            'offer_id' => 'Offer ID',
            'description_short' => 'Description Short',
            'description_long' => 'Description Long',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOffer()
    {
        return $this->hasOne(Offer::className(), ['id' => 'offer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcceptedResponse()
    {
        return $this->hasOne(Response::className(), ['id' => 'accepted_response_id']);
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
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['request_id' => 'id']);
    }
}