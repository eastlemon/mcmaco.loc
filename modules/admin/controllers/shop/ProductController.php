<?php

namespace app\modules\admin\controllers\shop;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use shop\entities\Shop\Product\Modification;
use shop\forms\manage\Shop\Product\QuantityForm;
use shop\forms\manage\Shop\Product\PhotosForm;
use shop\forms\manage\Shop\Product\PriceForm;
use shop\forms\manage\Shop\Product\ProductCreateForm;
use shop\forms\manage\Shop\Product\ProductEditForm;
use shop\useCases\manage\Shop\ProductManageService;
use shop\entities\Shop\Product\Product;
use app\modules\admin\models\Shop\ProductSearch;
use app\modules\admin\components\Navigator;

class ProductController extends Controller
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
                    'activate' => ['POST'],
                    'draft' => ['POST'],
                    'delete-photo' => ['POST'],
                    'move-photo-up' => ['POST'],
                    'move-photo-down' => ['POST'],
                ],
            ],
        ];
    }

    public static function titleIndex()
    {
        return Yii::t('shop', 'Products');
    }

    public static function crumbsToIndex()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']]
        ];
    }

    public static function crumbsToProduct()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],
            ['label' => static::titleIndex(), 'url' => ['/admin/shop/product']],
        ];
    }

    public function actionIndex()
    {
        $this->nav->title = static::titleIndex();
        $this->nav->crumbs = static::crumbsToIndex();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => static::titleCreate(), 'url' => ['/admin/shop/product/create']]
        ];

        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public static function titleView($id)
    {
        return Yii::t('shop', 'View');
    }

    public function actionView($id)
    {
        $product = $this->findModel($id);

        $this->nav->title = static::titleView($id);
        $this->nav->crumbs = static::crumbsToProduct();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Update'), 'url' => Url::to(['shop/product/update', 'id' => $id])],
            ['label' => Yii::t('shop', 'Delete'), 'url' => Url::to(['shop/product/delete', 'id' => $id]),
                'linkOptions' => [
                    'data-method' => 'POST',
                    'data-confirm' => Yii::t('shop', 'Are you sure you want to delete this item?'),
                ]
            ],
            ['label' => Yii::t('shop', 'Back'), 'url' => Url::to(['shop/product'])],
            ['label' => Yii::t('shop', 'Actions')],
            $product->isActive() ? [
                'label' => Yii::t('shop', 'Archive'), 'url' => Url::to(['shop/product/draft', 'id' => $id]),
                'linkOptions' => ['data-method' => 'POST']
            ] : [
                'label' => Yii::t('shop', 'Activate'), 'url' => Url::to(['shop/product/activate', 'id' => $id]),
                'linkOptions' => ['data-method' => 'POST'],
            ],
            ['label' => Yii::t('shop', 'Change Price'), 'url' => Url::to(['shop/product/price', 'id' => $id])],
            ['label' => Yii::t('shop', 'Change Quantity'), 'url' => Url::to(['shop/product/quantity', 'id' => $id])],
            ['label' => Yii::t('shop', 'Create modification'), 'url' => Url::to(['shop/modification/create', 'product_id' => $id])],
        ];

        $modificationsProvider = new ActiveDataProvider([
            'query' => $product->getModifications()->orderBy('name'),
            'key' => function (Modification $modification) use ($product) {
                return [
                    'product_id' => $product->id,
                    'id' => $modification->id,
                ];
            },
            'pagination' => false,
        ]);

        $photosForm = new PhotosForm();
        if ($photosForm->load(Yii::$app->request->post()) && $photosForm->validate()) {
            try {
                $this->service->addPhotos($product->id, $photosForm);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('view', [
            'product' => $product,
            'modificationsProvider' => $modificationsProvider,
            'photosForm' => $photosForm,
        ]);
    }

    public static function titleCreate()
    {
        return Yii::t('shop', 'Create');
    }

    public function actionCreate()
    {
        $this->nav->title = static::titleCreate();        
        $this->nav->crumbs = static::crumbsToProduct();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/shop/product']]
        ];

        $form = new ProductCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $product = $this->service->create($form);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public static function titleUpdate($id)
    {
        return Yii::t('shop', 'Update');
    }

    public function actionUpdate($id)
    {
        $this->nav->title = static::titleUpdate($id);
        $this->nav->crumbs = static::crumbsToProduct();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/shop/product']],
        ];

        $product = $this->findModel($id);

        $form = new ProductEditForm($product);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($product->id, $form);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    public function actionPrice($id)
    {
        $product = $this->findModel($id);

        $form = new PriceForm($product);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->changePrice($product->id, $form);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('price', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    public function actionQuantity($id)
    {
        $product = $this->findModel($id);

        $form = new QuantityForm($product);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->changeQuantity($product->id, $form);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('quantity', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    public function actionActivate($id)
    {
        try {
            $this->service->activate($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDraft($id)
    {
        try {
            $this->service->draft($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDeletePhoto($id, $photo_id)
    {
        try {
            $this->service->removePhoto($id, $photo_id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }

    public function actionMovePhotoUp($id, $photo_id)
    {
        $this->service->movePhotoUp($id, $photo_id);
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }

    public function actionMovePhotoDown($id, $photo_id)
    {
        $this->service->movePhotoDown($id, $photo_id);
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }

    protected function findModel($id): Product
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}