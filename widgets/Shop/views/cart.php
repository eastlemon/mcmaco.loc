<?php
use shop\helpers\PriceHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FAS;
?>

<div id="cart" class="btn-group btn-block">
    <button type="button" data-toggle="dropdown" data-loading-text="Loading..." class="btn btn-inverse btn-block btn-lg dropdown-toggle" aria-expanded="false">
        <?= FAS::icon('cart') ?>
        <span id="cart-total"><?= $cart->getAmount() ?> item(s) - <?= PriceHelper::format($cart->getCost()->getTotal()) ?></span>
    </button>
    <ul class="dropdown-menu pull-right">
        <li>
            <table class="table table-striped">
                <?php foreach ($cart->getItems() as $item): ?>
                <?php
                $product = $item->getProduct();
                $modification = $item->getModification();
                $url = Url::to(['/catalog/product', 'id' => $product->id]);
                ?>
                <tr>
                    <td class="text-center">
                        <?php if ($product->mainPhoto): ?>
                            <img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'cart_widget_list') ?>" alt="" class="img-thumbnail" />
                        <?php endif; ?>
                    </td>
                    <td class="text-left">
                        <a href="<?= $url ?>"><?= Html::encode($product->name) ?></a>
                        <?php if ($modification): ?>
                            <br/><small><?= Html::encode($modification->name) ?></small>
                        <?php endif; ?>
                    </td>
                    <td class="text-right">x <?= $item->getQuantity() ?></td>
                    <td class="text-right"><?= PriceHelper::format($item->getCost()) ?></td>
                    <td class="text-center"><a href="<?= Url::to(['/cart/remove', 'id' => $item->getId()]) ?>" title="Remove" class="btn btn-danger btn-xs" data-method="post"><?= FAS::icon('trash') ?></a></td>
                </tr>
                <?php endforeach ?>
            </table>
        </li>
        <li>
            <div>
                <?php $cost = $cart->getCost(); ?>
                <table class="table table-bordered">
                    <tr>
                        <td class="text-right"><strong>Sub-Total:</strong></td>
                        <td class="text-right"><?= PriceHelper::format($cost->getOrigin()) ?></td>
                    </tr>
                    <?php foreach ($cost->getDiscounts() as $discount): ?>
                        <tr>
                            <td class="text-right"><strong><?= Html::encode($discount->getName()) ?>:</strong></td>
                            <td class="text-right"><?= PriceHelper::format($discount->getValue()) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td class="text-right"><strong>Total:</strong></td>
                        <td class="text-right"><?= PriceHelper::format($cost->getTotal()) ?></td>
                    </tr>
                </table>
                <p class="text-right">
                    <a href="<?= Url::to(['/cart/index']) ?>"><strong><?= FAS::icon('cart') ?> View Cart</strong></a>
                    &nbsp;
                    <a href="/index.php?route=checkout/checkout"><strong><?= FAS::icon('checkout') ?> Checkout</strong></a>
                </p>
            </div>
        </li>
    </ul>
</div>
