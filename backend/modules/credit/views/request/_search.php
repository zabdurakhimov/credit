<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\credit\models\search\RequestSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'category_id') ?>

    <?php echo $form->field($model, 'type') ?>

    <?php echo $form->field($model, 'accepted_response_id') ?>

    <?php echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'offer_id') ?>

    <?php // echo $form->field($model, 'description_short') ?>

    <?php // echo $form->field($model, 'description_long') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
