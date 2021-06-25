<?php

use shop\helpers\PriceHelper;
use yii\bootstrap4\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FAS;

$url = Url::to(['product', 'id' => $product->id]);

?>

<div class="product-layout product-list col-md-12">
    <div class="product-thumb">
        <?php if ($product->mainPhoto) : ?>
            <div class="image">
                <a href="<?= Html::encode($url) ?>">
                    <img src="<?= Html::encode($product->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt="" class="img-responsive" />
                </a>
            </div>
        <?php endif; ?>
        <div>
            <div class="caption">
                <h4><a href="<?= Html::encode($url) ?>"><?= Html::encode($product->name) ?></a></h4>
                <p><?= Html::encode(StringHelper::truncateWords(strip_tags($product->description), 20)) ?></p>
                <p class="price">
                    <span class="price-new">$ <?= PriceHelper::format($product->price_new) ?></span>
                    <?php if ($product->price_old): ?>
                        <span class="price-old">$ <?= PriceHelper::format($product->price_old) ?></span>
                    <?php endif; ?>
                </p>
            </div>
            <button type="button" class="btn btn-primary" href="<?= Url::to(['/cart/add', 'id' => $product->id]) ?>" data-method="post"><?= Html::a(FAS::icon('cart-plus')) ?>&nbsp;<?= Yii::t('shop', 'Add to Cart') ?></button>
            <button type="button" class="btn btn-danger" data-toggle="tooltip" title="<?= Yii::t('shop', 'Add to Wish List') ?>" href="<?= Url::to(['/cabinet/wishlist/add', 'id' => $product->id]) ?>" data-method="post"><?= FAS::icon('heart') ?></button>
            <button type="button" class="btn btn-warning" data-toggle="tooltip" title="<?= Yii::t('shop', 'Compare this Product') ?>" onclick="compare.add('<?= $product->id ?>');"><?= FAS::icon('greater-than-equal') ?></button>
        </div>
    </div>
</div>