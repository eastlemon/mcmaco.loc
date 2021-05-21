<div class="tag-view">
    <div class="box">
        <div class="box-body">
            <?= \yii\widgets\DetailView::widget([
                'model' => $tag,
                'attributes' => [
                    'id',
                    'name',
                    'slug',
                ],
            ]) ?>
        </div>
    </div>
</div>