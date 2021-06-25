<?php

use yii\bootstrap4\Html;

$this->title = Yii::t('shop', 'Catalog');
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_subcategories', [
    'category' => $category
]) ?>

<hr>

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>