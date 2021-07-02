<?php

use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

?>

<div class="product-create">
    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
        <div class="box box-default">
            <div class="box-header with-border"><?= Yii::t('shop', 'Common') ?></div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'brandId')->dropDownList($model->brandsList()) ?>
                    </div>
                    <div class="col-md-2">
                        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <?= $form->field($model, 'description')->widget(CKEditor::className(), ['preset' => 'basic']) ?>
            </div>
        </div>
        <div class="box box-default">
            <div class="box-header with-border"><?= Yii::t('shop', 'Warehouse') ?></div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model->quantity, 'quantity')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-default">
            <div class="box-header with-border"><?= Yii::t('shop', 'Price') ?></div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model->price, 'new')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model->price, 'old')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border"><?= Yii::t('shop', 'Categories') ?></div>
                    <div class="box-body">
                        <?= $form->field($model->categories, 'main')->dropDownList($model->categories->categoriesList(), ['prompt' => '']) ?>
                        <?= $form->field($model->categories, 'others')->checkboxList($model->categories->categoriesList()) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border"><?= Yii::t('shop', 'Tags') ?></div>
                    <div class="box-body">
                        <?= $form->field($model->tags, 'existing')->checkboxList($model->tags->tagsList()) ?>
                        <?= $form->field($model->tags, 'textNew')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-default">
            <div class="box-header with-border"><?= Yii::t('shop', 'Characteristics') ?></div>
            <div class="box-body">
                <?php foreach ($model->values as $i => $value): ?>
                    <?php if ($variants = $value->variantsList()): ?>
                        <?= $form->field($value, '[' . $i . ']value')->dropDownList($variants, ['prompt' => '']) ?>
                    <?php else: ?>
                        <?= $form->field($value, '[' . $i . ']value')->textInput() ?>
                    <?php endif ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="box box-default">
            <div class="box-header with-border"><?= Yii::t('shop', 'Photos') ?></div>
            <div class="box-body">
                <?= $form->field($model->photos, 'files[]')->widget(FileInput::class, [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true,
                    ]
                ]) ?>
            </div>
        </div>
        <div class="box box-default">
            <div class="box-header with-border"><?= Yii::t('shop', 'SEO') ?></div>
            <div class="box-body">
                <?= $form->field($model->meta, 'title')->textInput() ?>
                <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>
                <?= $form->field($model->meta, 'keywords')->textInput() ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('shop', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>