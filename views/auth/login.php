<?php
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-6">
        <div>
            <h2>New Customer</h2>
            <p><strong>Register Account</strong></p>
            <p>By creating an account you will be able to shop faster, be up to date on an order's status,
                and keep track of the orders you have previously made.</p>
            <a href="<?= Html::encode(Url::to(['/signup'])) ?>" class="btn btn-primary">Continue</a>
        </div>
        <div>
            <h2>Social Login</h2>
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['network/auth']
            ]) ?>
        </div>
    </div>
    <div class="col-sm-6">
        <h2>Returning Customer</h2>
        <p><strong>I am a returning customer</strong></p>
        <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>
            <?= $form->field($model, 'username')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div style="color:#999;margin:1em 0">If you forgot your password you can <?= Html::a('reset it', ['/reset']) ?>.</div>
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>