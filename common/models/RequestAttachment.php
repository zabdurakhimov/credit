<?php

namespace common\models;


/**
 * This is the model class for table "request_attachment".
 *
 * @property int $id
 * @property int $request_id
 * @property int $order
 * @property string $path
 * @property string $base_url
 * @property int $created_at
 *
 * @property Request $request
 */
class RequestAttachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request_attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id', 'order', 'created_at'], 'default', 'value' => null],
            [['request_id', 'order', 'created_at'], 'integer'],
            [['path', 'base_url'], 'string', 'max' => 255],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Request::className(), 'targetAttribute' => ['request_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'request_id' => 'Request ID',
            'order' => 'Order',
            'path' => 'Path',
            'base_url' => 'Base Url',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::className(), ['id' => 'request_id']);
    }

    public function getUrl()
    {
        return $this->base_url . '/' . $this->path;
    }
}
