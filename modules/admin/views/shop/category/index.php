<?php

use shop\entities\Shop\Category;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use rmrevin\yii\fontawesome\FAS;

?>

<div class="category-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'name',
                        'value' => function (Category $model) {
                            $indent = ($model->depth > 1 ? str_repeat('&nbsp;&nbsp;', $model->depth - 1) . ' ' : '');
                            return $indent . Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'value' => function (Category $model) {
                            return
                                Html::a(FAS::icon('arrow-up'), ['move-up', 'id' => $model->id]) . '&nbsp;' .
                                Html::a(FAS::icon('arrow-down'), ['move-down', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'text-align:center; width:1px;'],
                    ],
                    'slug',
                    'title',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{update} {delete}',
                        'contentOptions' => ['style' => 'width:1px;'],
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>