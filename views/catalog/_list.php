<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;
use rmrevin\yii\fontawesome\FAS;

?>

<div class="row">
    <div class="col-md-2 col-sm-6 hidden-xs">
        <div class="btn-group btn-group-sm">
            <button type="button" id="list-view" class="btn btn-primary" data-toggle="tooltip" title="<?= Yii::t('shop', 'List') ?>"><?= Html::a(FAS::icon('list')) ?></button>
            <button type="button" id="grid-view" class="btn btn-primary" data-toggle="tooltip" title="<?= Yii::t('shop', 'Grid') ?>"><?= Html::a(FAS::icon('th')) ?></button>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="form-group">
            <a href="/index.php?route=product/compare" class="btn btn-warning btn-sm"><?= Yii::t('shop', 'Product Compare ({compare})', ['compare' => 0]) ?></a>
        </div>
    </div>
    <div class="col-md-4 col-xs-6">
        <div class="form-group input-group input-group-sm">
            <div class="input-group-prepend"><span class="input-group-text" id="basic-sort"><?= Yii::t('shop', 'Sort By') ?>:</span></div>
            <select id="input-sort" class="custom-select" onchange="location = this.value;" aria-describedby="basic-sort">
                <?php
                $values = [
                    '' => 'Default',
                    'name' => 'Name (A - Z)',
                    '-name' => 'Name (Z - A)',
                    'price' => 'Price (Low &gt; High)',
                    '-price' => 'Price (High &gt; Low)',
                    '-rating' => 'Rating (Highest)',
                    'rating' => 'Rating (Lowest)',
                ];
                $current = Yii::$app->request->get('sort');
                ?>
                <?php foreach ($values as $value => $label): ?>
                    <option value="<?= Html::encode(Url::current(['sort' => $value ?: null])) ?>" <?php if ($current == $value): ?>selected="selected"<?php endif; ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-3 col-xs-6">
        <div class="form-group input-group input-group-sm">
            <div class="input-group-prepend"><span class="input-group-text" id="basic-limit"><?= Yii::t('shop', 'Show') ?>:</span></div>
            <select id="input-limit" class="custom-select" onchange="location = this.value;" aria-describedby="basic-limit">
                <?php
                $values = [15, 25, 50, 75, 100];
                $current = $dataProvider->getPagination()->getPageSize();
                ?>
                <?php foreach ($values as $value): ?>
                    <option value="<?= Html::encode(Url::current(['per-page' => $value])) ?>" <?php if ($current == $value): ?>selected="selected"<?php endif; ?>><?= $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <?php foreach ($dataProvider->getModels() as $product) : ?>
        <?= $this->render('_product', [
            'product' => $product
        ]) ?>
    <?php endforeach; ?>
</div>

<div class="row">
    <div class="col-sm-6 text-left">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ]) ?>
    </div>
    <div class="col-sm-6 text-right">
        <?= Yii::t('shop', 'Showing {count} of {total}', [
            'count' => $dataProvider->getCount(),
            'total' => $dataProvider->getTotalCount(),
        ]) ?>
    </div>
</div>