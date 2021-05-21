<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

?>

<div class="product-price">
    <?php $form = ActiveForm::begin(); ?>
        <div class="box box-default">
            <div class="box-header with-border"><?= Yii::t('shop', 'Common') ?></div>
            <div class="box-body">
                <?= $form->field($model, 'new')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'old')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('shop', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>