<?php
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
?>
<div class="user-create">
    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'username')->textInput(['maxLength' => true]) ?>
                <?= $form->field($model, 'email')->textInput(['maxLength' => true]) ?>
                <?= $form->field($model, 'phone')->textInput(['maxLength' => true]) ?>
                <?= $form->field($model, 'password')->passwordInput(['maxLength' => true]) ?>
                <?= $form->field($model, 'role')->dropDownList($model->rolesList()) ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('shop', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>