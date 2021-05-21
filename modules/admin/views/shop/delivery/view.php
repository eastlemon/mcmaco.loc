<div class="delivery-view">
    <div class="box">
        <div class="box-body">
            <?= \yii\widgets\DetailView::widget([
                'model' => $method,
                'attributes' => [
                    'id',
                    'name',
                    'cost',
                    'min_weight',
                    'max_weight',
                ],
            ]) ?>
        </div>
    </div>
</div>
