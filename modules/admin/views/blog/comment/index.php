<?php
use shop\entities\Blog\Post\Comment;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\StringHelper;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'created_at:datetime',
        [
            'attribute' => 'text',
            'value' => function (Comment $model) {
                return StringHelper::truncate(strip_tags($model->text), 100);
            },
        ],
        [
            'attribute' => 'active',
            'filter' => $searchModel->activeList(),
            'format' => 'boolean',
        ],
        ['class' => ActionColumn::class],
    ],
]) ?>