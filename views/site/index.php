<?php

use app\widgets\Shop\FeaturedProductsWidget;
use app\widgets\Blog\LastPostsWidget;

$this->title = Yii::$app->params['app.caption'];
?>
<div class="site-index">
    
    <h3><?= Yii::t('app', 'Featured') ?></h3>

    <?= FeaturedProductsWidget::widget([
        'limit' => 4,
    ]) ?>

    <h3><?= Yii::t('app', 'Last Posts') ?></h3>

    <?= LastPostsWidget::widget([
        'limit' => 4,
    ]) ?>

</div>