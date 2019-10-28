<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\credit\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo kartik\tree\TreeView::widget([
        'query' => \common\models\Category::find()->addOrderBy('root, lft'),
        'headingOptions' => ['label' => 'Категории'],
        // 'headerOptions' => ['class' => 'category_h'],
        'rootOptions' => ['class' => 'category_h','label'=>'<span class="text-primary">Products</span>'],
        //'topRootAsHeading' => true, // this will override the headingOptions
        'fontAwesome' => true,
        'isAdmin' => false,
        //'keyAttribute' => true,
        'iconEditSettings'=> [
            'show' => 'none',
            'listData' => [
                'folder' => 'Folder',
                'file' => 'File',
                'mobile' => 'Phone',
                'bell' => 'Bell',
            ]
        ],
        //'displayValue' => 1, // initial display value
        /*'nodeAddlViews' => [
            \kartik\tree\Module::VIEW_PART_1 => '@backend/modules/content/views/category/_form',
            \kartik\tree\Module::VIEW_PART_2 => '@backend/modules/content/views/category/_attributes_form'
        ],*/
        'softDelete' => true,
        'cacheSettings' => ['enableCache' => true]
    ]); ?>

</div>
