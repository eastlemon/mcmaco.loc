<?php
use shop\helpers\PriceHelper;
use shop\helpers\WeightHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FAS;

$this->title = 'Shopping Cart';
$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['/catalog/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-index">
    <h1><?= Html::encode($this->title) ?></h1>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td class="text-center" style="width: 100px">Image</td>
                    <td class="text-left">Product Name</td>
                    <td class="text-left">Model</td>
                    <td class="text-left">Quantity</td>
                    <td class="text-right">Unit Price</td>
                    <td class="text-right">Total</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cart->getItems() as $item): ?>
                    <?php
                    $product = $item->getProduct();
                    $modification = $item->getModification();
                    $url = Url::to(['/catalog/product', 'id' => $product->id]);
                    ?>
                    <tr>
                        <td class="text-center">
                            <a href="<?= $url ?>">
                                <?php if ($product->mainPhoto): ?>
                                    <img src="<?= $product->mainPhoto->getThumbFileUrl('file', 'cart_list') ?>" alt="" class="img-thumbnail" />
                                <?php endif; ?>
                            </a>
                        </td>
                        <td class="text-left">
                            <a href="<?= $url ?>"><?= Html::encode($product->name) ?></a>
                        </td>
                        <td class="text-left">
                            <?php if ($modification): ?>
                                <?= Html::encode($modification->name) ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-left">
                            <div class="input-group btn-block" style="max-width: 200px;">
                                <div class="btn-group">
                                    <input type="text" name="quantity" value="<?= $item->getQuantity() ?>" size="1" class="form-control" />
                                    <button type="button" class="btn btn-primary" data-toggle="tooltip" title="<?= Yii::t('shop', 'Update') ?>" href="<?= Url::to(['quantity', 'id' => $item->getId()]) ?>" data-method="post"><?= Html::a(FAS::icon('sync')) ?></button>
                                    <button type="button" class="btn btn-danger" data-toggle="tooltip" title="<?= Yii::t('shop', 'Remove') ?>" href="<?= Url::to(['/cart/remove', 'id' => $item->getId()]) ?>" data-method="post"><?= FAS::icon('trash') ?></button>
                                </div>
                            </div>
                        </td>
                        <td class="text-right"><?= PriceHelper::format($item->getPrice()) ?></td>
                        <td class="text-right"><?= PriceHelper::format($item->getCost()) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    
    <br />
    <div class="row">
        <div class="col-sm-4 col-sm-offset-8">
            <?php $cost = $cart->getCost() ?>
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
                <tr>
                    <td class="text-right"><strong>Weight:</strong></td>
                    <td class="text-right"><?= WeightHelper::format($cart->getWeight()) ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="buttons clearfix">
        <div class="pull-left"><a href="<?= Url::to('/catalog/index') ?>" class="btn btn-default">Continue Shopping</a></div>
        <?php if ($cart->getItems()): ?>
            <div class="pull-right"><a href="<?= Url::to('/checkout/index') ?>" class="btn btn-primary">Checkout</a></div>
        <?php endif; ?>
    </div>
</div>
    
