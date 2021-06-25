<?php

namespace app\widgets\Shop;

use yii\base\Widget;
use yii\helpers\Html;
use shop\entities\Shop\Category;
use shop\readModels\Shop\CategoryReadRepository;
use shop\readModels\Shop\views\CategoryView;

class CategoriesWidget extends Widget
{
    public $active;
    private $categories;

    public function __construct(CategoryReadRepository $categories, $config = [])
    {
        parent::__construct($config);
        $this->categories = $categories;
    }

    public function run(): string
    {
        return Html::tag('div', implode(PHP_EOL, array_map(function (CategoryView $view) {
            $indent = ($view->category->depth > 1 ? str_repeat('&nbsp;&nbsp;&nbsp;', $view->category->depth - 1) . '- ' : '');
            $active = $this->active && ($this->active->id == $view->category->id || $this->active->isChildOf($view->category));
            return Html::a(
                $indent . Html::encode($view->category->name) . ' (' . $view->count . ')',
                ['/catalog/category', 'id' => $view->category->id],
                ['class' => $active ? 'list-group-item active' : 'list-group-item']
            );
        }, $this->categories->getTreeWithSubsOf($this->active))), [
            'class' => 'list-group',
        ]);
    }
}