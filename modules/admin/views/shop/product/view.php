<?php
use kartik\file\FileInput;
use shop\entities\Shop\Product\Modification;
use shop\entities\Shop\Product\Value;
use shop\helpers\PriceHelper;
use shop\helpers\ProductHelper;
use shop\helpers\WeightHelper;
use yii\bootstrap4\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use rmrevin\yii\fontawesome\FAS;
?>

<div class="product-view">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border"><?= Yii::t('shop', 'Common') ?></div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'status',
                                'value' => ProductHelper::statusLabel($product->status),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'brand_id',
                                'value' => ArrayHelper::getValue($product, 'brand.name'),
                            ],
                            'code',
                            'name',
                            [
                                'attribute' => 'category_id',
                                'value' => ArrayHelper::getValue($product, 'category.name'),
                            ],
                            [
                                'value' => implode(', ', ArrayHelper::getColumn($product->categories, 'name')),
                                'label' => Yii::t('shop', 'Other categories'),
                            ],
                            [
                                'value' => implode(', ', ArrayHelper::getColumn($product->tags, 'name')),
                                'label' => Yii::t('shop', 'Tags'),
                            ],
                            'quantity',
                            [
                                'attribute' => 'weight',
                                'value' => WeightHelper::format($product->weight),
                            ],
                            [
                                'attribute' => 'price_new',
                                'value' => PriceHelper::format($product->price_new),
                            ],
                            [
                                'attribute' => 'price_old',
                                'value' => PriceHelper::format($product->price_old),
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border"><?= Yii::t('shop', 'Characteristics') ?></div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => array_map(function (Value $value) {
                            return [
                                'label' => $value->characteristic->name,
                                'value' => $value->value,
                            ];
                        }, $product->values),
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border"><?= Yii::t('shop', 'Description') ?></div>
        <div class="box-body">
            <?= Yii::$app->formatter->asHtml($product->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
    <div class="box" id="modifications">
        <div class="box-header with-border"><?= Yii::t('shop', 'Modifications') ?></div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $modificationsProvider,
                'columns' => [
                    'code',
                    'name',
                    [
                        'attribute' => 'price',
                        'value' => function (Modification $model) {
                            return PriceHelper::format($model->price);
                        },
                    ],
                    'attribute' => 'quantity',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'controller' => 'shop/modification',
                        'template'=>'{update} {delete}',
                        'contentOptions' => ['style' => 'width:1px;'],
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border"><?= Yii::t('shop', 'SEO') ?></div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $product,
                'attributes' => [
                    [
                        'attribute' => 'meta.title',
                        'value' => $product->meta->title,
                    ],
                    [
                        'attribute' => 'meta.description',
                        'value' => $product->meta->description,
                    ],
                    [
                        'attribute' => 'meta.keywords',
                        'value' => $product->meta->keywords,
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <div class="box" id="photos">
        <div class="box-header with-border"><?= Yii::t('shop', 'Photos') ?></div>
        <div class="box-body">
            <div class="row">
                <?php foreach ($product->photos as $photo): ?>
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div class="btn-group">
                            <?= Html::a(FAS::icon('arrow-left'), ['move-photo-up', 'id' => $product->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]) ?>
                            <?= Html::a(FAS::icon('trash'), ['delete-photo', 'id' => $product->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                                'data-confirm' => 'Remove photo?',
                            ]) ?>
                            <?= Html::a(FAS::icon('arrow-right'), ['move-photo-down', 'id' => $product->id, 'photo_id' => $photo->id], [
                                'class' => 'btn btn-default',
                                'data-method' => 'post',
                            ]) ?>
                        </div>
                        <div>
                            <?= Html::a(Html::img($photo->getThumbFileUrl('file', 'thumb')), $photo->getUploadedFileUrl('file'), ['class' => 'thumbnail', 'target' => '_blank']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <br />
            <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
                <?= $form->field($photosForm, 'files[]')->label(false)->widget(FileInput::class, [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true,
                    ]
                ]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>