<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

?>

<div class="product-quantity">
    <?php $form = ActiveForm::begin(); ?>
        <div class="box box-default">
            <div class="box-body">
                <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('shop', 'Save'), ['class' => 'btn btn-success', 'disabled' => $product->canChangeQuantity()]) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>