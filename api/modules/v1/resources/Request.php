<?php

namespace api\modules\v1\resources;

use common\models\Category;
use common\models\Offer;
use common\models\Response;
use common\models\User;
use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;
use yii\web\UploadedFile;

/**
 * @author Ziyod Andurakhimov
 */
class Request extends \common\models\Request implements Linkable
{

    public $initial_pay;
    public $total_pay;
    public $period;
    public $status_label;

    /**
     * @property Offer offer
     */



    public function fields()
    {
        return ['type', 'accepted_response_id', 'status', 'description_short','typeLabel', 'statusLabel',
            'description_long', 'created_at', 'category', 'createdBy', 'acceptedResponse', 'offer', 'initial_pay', 'total_pay', 'period', 'attachments', 'status_label'];
    }

    public function extraFields()
    {
        return ['category', 'offer', 'acceptedResponse'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['initial_pay', 'total_pay', 'period'], 'required'],
//            [['category_id', 'description_short', 'description_long', 'type', 'offer'], 'required'],
            ['status', 'default', 'value' => self::STATUS_NEW],
//            ['offer', 'default', 'value' => new Offer()],
            ['offer_id', 'default', 'value' => $this->offer ? $this->offer->id : null],
            ['created_at', 'default', 'value' => time()],
            ['created_by', 'default', 'value' => \Yii::$app->user->identity->primaryKey],
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
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['request/view', 'id' => $this->id], true)
        ];
    }

    public function beforeSave($insert)
    {
        $uploads = UploadedFile::getInstancesByName("upfile");
        if (empty($uploads)){
            return "Must upload at least 1 file in upfile form-data POST";
        }

        // $uploads now contains 1 or more UploadedFile instances
        $savedfiles = [];
        foreach ($uploads as $file){
            $path = '/file/storage/upload';
                $file->saveAs($path); //Your uploaded file is saved, you can process it further from here

        }


        if ($insert) {
            $offer = new Offer();
            $offer->initial_pay = $this->initial_pay;
            $offer->total_pay = $this->total_pay;
            $offer->period = $this->period;
            $offer->save();
            $this->offer_id = $offer->id;
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }



}
