<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Request */

$this->title = 'Create Request';
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
