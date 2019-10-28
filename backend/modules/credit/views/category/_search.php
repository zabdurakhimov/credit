<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\credit\models\search\CategorySearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'root') ?>

    <?php echo $form->field($model, 'lft') ?>

    <?php echo $form->field($model, 'rgt') ?>

    <?php echo $form->field($model, 'lvl') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'child_allowed')->checkbox() ?>

    <?php // echo $form->field($model, 'icon') ?>

    <?php // echo $form->field($model, 'icon_type') ?>

    <?php // echo $form->field($model, 'active')->checkbox() ?>

    <?php // echo $form->field($model, 'selected')->checkbox() ?>

    <?php // echo $form->field($model, 'disabled')->checkbox() ?>

    <?php // echo $form->field($model, 'readonly')->checkbox() ?>

    <?php // echo $form->field($model, 'visible')->checkbox() ?>

    <?php // echo $form->field($model, 'collapsed')->checkbox() ?>

    <?php // echo $form->field($model, 'movable_u')->checkbox() ?>

    <?php // echo $form->field($model, 'movable_d')->checkbox() ?>

    <?php // echo $form->field($model, 'movable_l')->checkbox() ?>

    <?php // echo $form->field($model, 'movable_r')->checkbox() ?>

    <?php // echo $form->field($model, 'removable')->checkbox() ?>

    <?php // echo $form->field($model, 'removable_all')->checkbox() ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
