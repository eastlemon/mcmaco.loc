<?php
use shop\entities\Blog\Category;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
?>
<div class="user-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'sort',
            [
                'attribute' => 'name',
                'value' => function (Category $model) {
                    return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                },
                'format' => 'raw',
            ],
            'slug',
            'title',
            ['class' => ActionColumn::class],
        ],
    ]) ?>
</div>