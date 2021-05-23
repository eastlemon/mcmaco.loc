<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;
use rmrevin\yii\fontawesome\FAS;

AppAsset::register($this);

$index = Yii::$app->controller->route == Yii::$app->defaultRoute;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap<?= $index ? '-index' : '' ?>">
    <?php
    NavBar::begin([
        'brandLabel' => FAS::icon('shopping-cart') . ' McMaco',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-dark bg-dark fixed-top',
            'role' => 'navigation',
        ]
    ]);

    $menuItems = [
        ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],
        Yii::$app->user->isGuest ? (['label' => Yii::t('shop', 'Login'), 'url' => ['/site/login']]) : ('<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            Yii::t('shop', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>')
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>

    <?php if ($index) : ?>
        <header class="bg-primary py-5 mb-5">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-lg-12">
                        <h1 class="display-4 text-white mt-5 mb-2">Тема блока</h1>
                        <p class="lead mb-5 text-white-50">Содержание блока</p>
                    </div>
                </div>
            </div>
        </header>
    <?php endif; ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">&copy; McMaco 2021</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>