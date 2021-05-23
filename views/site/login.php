<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'McMaco - Вход';
$this->params['breadcrumbs'][] = 'Вход';
?>
<div class="site-login">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card my-5">
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <div class="form-label-group">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                        </div>

                        <div class="form-label-group">
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        </div>

                        <div class="form-label-group">
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                        </div>
                        <?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2']) ?>            
                        <div style="color:#999;margin:1em 0"><?= Yii::t('app', 'If you forgot your password you can') ?> <?= Html::a(Yii::t('app', 'reset it'), ['request-password-reset']) ?></div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>