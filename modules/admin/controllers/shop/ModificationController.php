<?php

namespace app\modules\admin\controllers\shop;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use shop\forms\manage\Shop\Product\ModificationForm;
use shop\useCases\manage\Shop\ProductManageService;
use shop\entities\Shop\Product\Product;
use app\modules\admin\components\Navigator;

class ModificationController extends Controller
{
    private $service;
    public $nav;

    public function __construct($id, $module, ProductManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->nav = new Navigator();
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public static function crumbsToProduct($id)
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],
            ['label' => Yii::t('shop', 'Products'), 'url' => Url::to(['shop/product'])],
            ['label' => Yii::t('shop', 'Product {id}', ['id' => $id]), 'url' => Url::to(['shop/product/view', 'id' => $id])],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect('shop/product');
    }

    public static function titleCreate()
    {
        return Yii::t('shop', 'Create modification');
    }

    public function actionCreate($product_id)
    {
        $product = $this->findModel($product_id);

        $this->nav->title = static::titleCreate();        
        $this->nav->crumbs = static::crumbsToProduct($product_id);
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => Url::to(['shop/product/view', 'id' => $product_id])],
        ];

        $form = new ModificationForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addModification($product->id, $form);
                return $this->redirect(['shop/product/view', 'id' => $product->id, '#' => 'modifications']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'product' => $product,
            'model' => $form,
        ]);
    }
    
    public static function titleUpdate()
    {
        return Yii::t('shop', 'Update modification');
    }

    public function actionUpdate($product_id, $id)
    {
        $product = $this->findModel($product_id);
        $modification = $product->getModification($id);

        $this->nav->title = static::titleUpdate();        
        $this->nav->crumbs = static::crumbsToProduct($product_id);
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => Url::to(['shop/product/view', 'id' => $product_id])],
        ];

        $form = new ModificationForm($modification);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editModification($product->id, $modification->id, $form);
                return $this->redirect(['shop/product/view', 'id' => $product->id, '#' => 'modifications']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'product' => $product,
            'model' => $form,
            'modification' => $modification,
        ]);
    }

    public function actionDelete($product_id, $id)
    {
        $product = $this->findModel($product_id);
        try {
            $this->service->removeModification($product->id, $id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['shop/product/view', 'id' => $product->id, '#' => 'modifications']);
    }

    protected function findModel($id): Product
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}