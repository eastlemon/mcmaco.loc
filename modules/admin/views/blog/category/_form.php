<?php
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="category-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="box box-default">
            <div class="box-header with-border">Common</div>
            <div class="box-body">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->widget(CKEditor::className(), ['preset' => 'basic']) ?>

            </div>
        </div>
        <div class="box box-default">
            <div class="box-header with-border">SEO</div>
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