<?php
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
?>
<div class="brand-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="box box-default">
            <div class="box-header with-border"><?= Yii::t('shop', 'Common') ?></div>
            <div class="box-body">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

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