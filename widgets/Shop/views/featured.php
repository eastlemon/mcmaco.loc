<?php

use shop\helpers\PriceHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FAS;

?>

<div class="row">
    <?php foreach ($products as $product): ?>
        <?php $url = Url::to(['/catalog/product', 'id' =>$product->id]); ?>
        <div class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="product-thumb transition">
                <?php if ($product->mainPhoto): ?>
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
                            <span class="price-new">$<?= PriceHelper::format($product->price_new) ?></span>
                            <?php if ($product->price_old): ?>
                                <span class="price-old">$<?= PriceHelper::format($product->price_old) ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-toggle="tooltip" title="<?= Yii::t('shop', 'Add to Cart') ?>"  href="<?= Url::to(['/cart/add', 'id' => $product->id]) ?>" data-method="post"><?= Html::a(FAS::icon('cart-plus')) ?></button>
                        <button type="button" class="btn btn-danger" data-toggle="tooltip" title="<?= Yii::t('shop', 'Add to Wish List') ?>" href="<?= Url::to(['/cabinet/wishlist/add', 'id' => $product->id]) ?>" data-method="post"><?= FAS::icon('heart') ?></button>
                        <button type="button" class="btn btn-warning" data-toggle="tooltip" title="<?= Yii::t('shop', 'Compare this Product') ?>" onclick="compare.add('<?= $product->id ?>');"><?= FAS::icon('greater-than-equal') ?></button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>