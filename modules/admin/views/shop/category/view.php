<?php

use yii\widgets\DetailView;

?>

<div class="category-view">
    <div class="box">
        <div class="box-header with-border"><?= Yii::t('shop', 'Common') ?></div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $category,
                'attributes' => [
                    'id',
                    'name',
                    'name',
                    'title',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border"><?= Yii::t('shop', 'Description') ?></div>
        <div class="box-body">
            <?= Yii::$app->formatter->asHtml($category->description, [
                'Attr.AllowedRel' => array('nofollow'),
                'HTML.SafeObject' => true,
                'Output.FlashCompat' => true,
                'HTML.SafeIframe' => true,
                'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border"><?= Yii::t('shop', 'SEO') ?></div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $category,
                'attributes' => [
                    'meta.title',
                    'meta.description',
                    'meta.keywords',
                ],
            ]) ?>
        </div>
    </div>
</div>