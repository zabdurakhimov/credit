<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Request */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'category_id')->textInput() ?>

    <?php echo $form->field($model, 'type')->textInput() ?>

    <?php echo $form->field($model, 'accepted_response_id')->textInput() ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

    <?php echo $form->field($model, 'offer_id')->textInput() ?>

    <?php echo $form->field($model, 'description_short')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description_long')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'created_by')->textInput() ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
