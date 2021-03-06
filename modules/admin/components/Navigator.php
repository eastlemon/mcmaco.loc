<?php

namespace app\modules\admin\components;

use Yii;

class Navigator extends \dmitrybtn\yimp\Navigator
{
    public function init()
    {
        parent::init();

        $this->menuLeft = [
            ['label' => Yii::t('shop', 'Menu')],
            ['label' => Yii::t('shop', 'Users'), 'url' => ['/admin/user'], 'active' => 'admin/user/*'],
            ['label' => Yii::t('shop', 'Pages'), 'url' => ['/admin/page'], 'active' => 'admin/page/*'],
            ['label' => Yii::t('shop', 'Files'), 'url' => ['/admin/file'], 'active' => 'admin/file/*'],
            ['label' => Yii::t('shop', 'Shop')],
            ['label' => Yii::t('shop', 'Tags'), 'url' => ['/admin/shop/tag'], 'active' => 'admin/shop/tag/*'],
            ['label' => Yii::t('shop', 'Brands'), 'url' => ['/admin/shop/brand'], 'active' => 'admin/shop/brand/*'],
            ['label' => Yii::t('shop', 'Categories'), 'url' => ['/admin/shop/category'], 'active' => 'admin/shop/category/*'],
            ['label' => Yii::t('shop', 'Products'), 'url' => ['/admin/shop/product'], 'active' => 'admin/shop/product/*'],
            ['label' => Yii::t('shop', 'Characteristic'), 'url' => ['/admin/shop/characteristic'], 'active' => 'admin/shop/characteristic/*'],
            ['label' => Yii::t('shop', 'Delivery'), 'url' => ['/admin/shop/delivery'], 'active' => 'admin/shop/delivery/*'],
            ['label' => Yii::t('shop', 'Orders'), 'url' => ['/admin/shop/order'], 'active' => 'admin/shop/order/*'],
            ['label' => Yii::t('shop', 'Blog')],
            ['label' => Yii::t('shop', 'Tags'), 'url' => ['/admin/blog/tag'], 'active' => 'admin/blog/tags/*'],
            ['label' => Yii::t('shop', 'Categories'), 'url' => ['/admin/blog/category'], 'active' => 'admin/blog/category/*'],
            ['label' => Yii::t('shop', 'Posts'), 'url' => ['/admin/blog/post'], 'active' => 'admin/blog/posts/*'],
            ['label' => Yii::t('shop', 'Comments'), 'url' => ['/admin/blog/comment'], 'active' => 'admin/blog/comment/*'],
        ];
    }
}