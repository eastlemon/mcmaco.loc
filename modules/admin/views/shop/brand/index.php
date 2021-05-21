<?php

use shop\entities\Shop\Brand;
use yii\bootstrap4\Html;
use yii\grid\GridView;

?>

<div class="brand-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'name',
                        'label' => Yii::t('shop', 'Name'),
                        'value' => function (Brand $model) {
                            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'slug',
                        'label' => Yii::t('shop', 'Slug'),
                    ],
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