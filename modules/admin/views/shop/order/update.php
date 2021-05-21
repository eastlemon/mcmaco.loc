<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>

<div class="order-update">
    <?php $form = ActiveForm::begin() ?>
        <div class="box box-default">
            <div class="box-header with-border"><?= Yii::t('shop', 'Customer') ?></div>
            <div class="box-body">
                <?= $form->field($model->customer, 'phone')->textInput() ?>
                <?= $form->field($model->customer, 'name')->textInput() ?>
            </div>
        </div>
        <div class="box box-default">
            <div class="box-header with-border"><?= Yii::t('shop', 'Delivery') ?></div>
            <div class="box-body">
                <?= $form->field($model->delivery, 'method')->dropDownList($model->delivery->deliveryMethodsList(), ['prompt' => '--- Select ---']) ?>
                <?= $form->field($model->delivery, 'index')->textInput() ?>
                <?= $form->field($model->delivery, 'address')->textarea(['rows' => 3]) ?>
            </div>
        </div>
        <div class="box box-default">
            <div class="box-header with-border"><?= Yii::t('shop', 'Note') ?></div>
            <div class="box-body">
                <?= $form->field($model, 'note')->textarea(['rows' => 3]) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('shop', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>