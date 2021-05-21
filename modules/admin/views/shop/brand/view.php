<?php

use yii\widgets\DetailView;

?>

<div class="brand-view">
    <div class="box">
        <div class="box-header with-border"><?= Yii::t('shop', 'Common') ?></div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $brand,
                'attributes' => [
                    [
                        'attribute' => 'id',
                        'label' => Yii::t('shop', 'Id'),
                    ],
                    [
                        'attribute' => 'name',
                        'label' => Yii::t('shop', 'Name'),
                    ],
                    [
                        'attribute' => 'name',
                        'label' => Yii::t('shop', 'Slug'),
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border"><?= Yii::t('shop', 'SEO') ?></div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $brand,
                'attributes' => [
                    'meta.title',
                    'meta.description',
                    'meta.keywords',
                ],
            ]) ?>
        </div>
    </div>
</div>