<?php

use shop\helpers\OrderHelper;
use shop\helpers\PriceHelper;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;

?>

<div class="order-view">
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $order,
                'attributes' => [
                    'id',
                    'created_at:datetime',
                    [
                        'attribute' => 'current_status',
                        'value' => OrderHelper::statusLabel($order->current_status),
                        'format' => 'raw',
                    ],
                    'user_id',
                    'delivery_method_name',
                    'deliveryData.index',
                    'deliveryData.address',
                    'cost',
                    'note:ntext',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="margin-bottom: 0">
                    <thead>
                        <tr>
                            <th class="text-left">Product Name</th>
                            <th class="text-left">Model</th>
                            <th class="text-left">Quantity</th>
                            <th class="text-right">Unit Price</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order->items as $item): ?>
                            <tr>
                                <td class="text-left">
                                    <?= Html::encode($item->product_code) ?><br />
                                    <?= Html::encode($item->product_name) ?>
                                </td>
                                <td class="text-left">
                                    <?= Html::encode($item->modification_code) ?><br />
                                    <?= Html::encode($item->modification_name) ?>
                                </td>
                                <td class="text-left">
                                    <?= $item->quantity ?>
                                </td>
                                <td class="text-right"><?= PriceHelper::format($item->price) ?></td>
                                <td class="text-right"><?= PriceHelper::format($item->getCost()) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="margin-bottom: 0">
                    <thead>
                    <tr>
                        <th class="text-left">Date</th>
                        <th class="text-left">Staus</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($order->statuses as $status): ?>
                        <tr>
                            <td class="text-left">
                                <?= Yii::$app->formatter->asDatetime($status->created_at) ?>
                            </td>
                            <td class="text-left">
                                <?= OrderHelper::statusLabel($status->value) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>