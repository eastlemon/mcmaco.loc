<?php

namespace app\modules\admin\controllers\shop;

use shop\forms\manage\Shop\DeliveryMethodForm;
use shop\useCases\manage\Shop\DeliveryMethodManageService;
use Yii;
use shop\entities\Shop\DeliveryMethod;
use app\modules\admin\models\Shop\DeliveryMethodSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\modules\admin\components\Navigator;

class DeliveryController extends Controller
{
    private $service;
    public $nav;

    public function __construct($id, $module, DeliveryMethodManageService $service, $config = [])
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

    public static function titleIndex()
    {
        return Yii::t('shop', 'Delivery');
    }

    public static function crumbsToIndex()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],
        ];
    }

    public static function crumbsToDelivery()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],            
            ['label' => static::titleIndex(), 'url' => ['/admin/shop/delivery']],
        ];
    }

    public function actionIndex()
    {
        $this->nav->title = static::titleIndex();
        $this->nav->crumbs = static::crumbsToIndex();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => static::titleCreate(), 'url' => ['/admin/shop/delivery/create']],
        ];

        $searchModel = new DeliveryMethodSearch();
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
        $this->nav->title = static::titleView($id);
        $this->nav->crumbs = static::crumbsToDelivery();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Update'), 'url' => Url::to(['shop/delivery/update', 'id' => $id])],
            ['label' => Yii::t('shop', 'Delete'), 'url' => Url::to(['shop/delivery/delete', 'id' => $id]),
                'linkOptions' => [
                    'data-method' => 'POST',
                    'data-confirm' => Yii::t('shop', 'Are you sure you want to delete this item?'),
                ]
            ],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/shop/delivery']],
        ];

        return $this->render('view', [
            'method' => $this->findModel($id),
        ]);
    }

    public static function titleCreate()
    {
        return Yii::t('shop', 'Create');
    }

    public function actionCreate()
    {
        $this->nav->title = static::titleCreate();
        $this->nav->crumbs = static::crumbsToDelivery();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/shop/delivery']],
        ];

        $form = new DeliveryMethodForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $method = $this->service->create($form);
                return $this->redirect(['view', 'id' => $method->id]);
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
        $this->nav->crumbs = static::crumbsToDelivery();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/shop/delivery']],
        ];

        $method = $this->findModel($id);

        $form = new DeliveryMethodForm($method);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($method->id, $form);
                return $this->redirect(['view', 'id' => $method->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'method' => $method,
        ]);
    }
    
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id): DeliveryMethod
    {
        if (($model = DeliveryMethod::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}