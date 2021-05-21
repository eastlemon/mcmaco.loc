<?php

use shop\entities\Shop\Characteristic;
use shop\helpers\CharacteristicHelper;
use yii\bootstrap4\Html;
use yii\grid\GridView;

?>

<div class="characteristic-index">
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'name',
                        'value' => function (Characteristic $model) {
                            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'type',
                        'filter' => $searchModel->typesList(),
                        'value' => function (Characteristic $model) {
                            return CharacteristicHelper::typeName($model->type);
                        },
                    ],
                    [
                        'attribute' => 'required',
                        'filter' => $searchModel->requiredList(),
                        'format' => 'boolean',
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