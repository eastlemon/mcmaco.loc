<?php

use shop\entities\Page;
use yii\bootstrap4\Html;
use yii\grid\GridView;

?>

<div class="page-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'title',
                        'value' => function (Page $model) {
                            $indent = ($model->depth > 1 ? str_repeat('&nbsp;&nbsp;', $model->depth - 1) . ' ' : '');
                            return $indent . Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'value' => function (Page $model) {
                            return
                                Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['move-up', 'id' => $model->id]) .
                                Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', ['move-down', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'text-align: center'],
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