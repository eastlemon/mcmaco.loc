<?php
use yii\widgets\DetailView;
?>
<div class="page-view">
    <div class="box">
        <div class="box-header with-border"><?= Yii::t('shop', 'Common') ?></div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $page,
                'attributes' => [
                    'id',
                    'title',
                    'slug',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border"><?= Yii::t('shop', 'Content') ?></div>
        <div class="box-body">
            <?= Yii::$app->formatter->asHtml($page->content, [
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
                'model' => $page,
                'attributes' => [
                    'meta.title',
                    'meta.description',
                    'meta.keywords',
                ],
            ]) ?>
        </div>
    </div>
</div>