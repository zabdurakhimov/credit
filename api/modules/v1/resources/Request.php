<?php

namespace api\modules\v1\resources;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Request extends \common\models\Request implements Linkable
{
    public function fields()
    {
        return ['id', 'type', 'accepted_response_id', 'status', 'offer_id', 'description_short',
            'description_long', 'created_at', 'category', 'createdBy', 'acceptedResponse', 'offer'];
    }

    public function extraFields()
    {
        return ['category', 'offer', 'acceptedResponse'];
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
}
