<?php

namespace app\widgets\Shop;

use yii\base\Widget;
use shop\readModels\Shop\ProductReadRepository;

class FeaturedProductsWidget extends Widget
{
    public $limit;
    private $repository;

    public function __construct(ProductReadRepository $repository, $config = [])
    {
        parent::__construct($config);
        $this->repository = $repository;
    }

    public function run()
    {
        return $this->render('featured', [
            'products' => $this->repository->getFeatured($this->limit)
        ]);
    }
}