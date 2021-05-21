<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

?>

<div class="delivery-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="box box-default">
            <div class="box-body">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'cost')->textInput() ?>
                <?= $form->field($model, 'minWeight')->textInput() ?>
                <?= $form->field($model, 'maxWeight')->textInput() ?>
                <?= $form->field($model, 'sort')->textInput() ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('shop', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>