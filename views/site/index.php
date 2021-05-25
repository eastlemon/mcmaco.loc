<?php

use app\widgets\Blog\LastPostsWidget;
use app\widgets\Shop\FeaturedProductsWidget;

$this->title = 'McMaco - Интернет-магазин';
?>
<div class="site-index">
    
    <h3>Featured</h3>

    <?= FeaturedProductsWidget::widget([
        'limit' => 4,
    ]) ?>

    <h3>Last Posts</h3>

    <?= LastPostsWidget::widget([
        'limit' => 4,
    ]) ?>

</div>