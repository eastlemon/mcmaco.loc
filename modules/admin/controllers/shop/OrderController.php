<?php

namespace app\modules\admin\controllers\shop;

use shop\forms\manage\Shop\Order\OrderEditForm;
use shop\forms\manage\Shop\OrderForm;
use shop\useCases\manage\Shop\OrderManageService;
use Yii;
use shop\entities\Shop\Order\Order;
use app\modules\admin\models\Shop\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\helpers\Url;
use app\modules\admin\components\Navigator;

class OrderController extends Controller
{
    private $service;
    public $nav;

    public function __construct($id, $module, OrderManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->nav = new Navigator();
    }

    public static function titleIndex()
    {
        return Yii::t('shop', 'Orders');
    }

    public static function crumbsToIndex()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],
        ];
    }

    public static function crumbsToOrder()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],            
            ['label' => static::titleIndex(), 'url' => ['/admin/shop/order']],
        ];
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'export' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->nav->title = static::titleIndex();
        $this->nav->crumbs = static::crumbsToIndex();
        /*$this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            //['label' => static::titleCreate(), 'url' => ['/admin/shop/order/create']],
        ];*/

        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExport()
    {
        $query = Order::find()->orderBy(['id' => SORT_DESC]);

        $objPHPExcel = new Spreadsheet();

        $worksheet = $objPHPExcel->getActiveSheet();

        foreach ($query->each() as $row => $order) {
            $worksheet->setCellValueByColumnAndRow(0, $row + 1, $order->id);
            $worksheet->setCellValueByColumnAndRow(1, $row + 1, date('Y-m-d H:i:s', $order->created_at));
        }

        $objWriter = new Xlsx($objPHPExcel);
        $file = tempnam(sys_get_temp_dir(), 'export');
        $objWriter->save($file);

        return Yii::$app->response->sendFile($file, 'report.xlsx');
    }

    public static function titleView($id)
    {
        return Yii::t('shop', 'View');
    }

    public function actionView($id)
    {
        $this->nav->title = static::titleView($id);
        $this->nav->crumbs = static::crumbsToOrder();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Update'), 'url' => Url::to(['shop/order/update', 'id' => $id])],
            ['label' => Yii::t('shop', 'Delete'), 'url' => Url::to(['shop/order/delete', 'id' => $id]),
                'linkOptions' => [
                    'data-method' => 'POST',
                    'data-confirm' => Yii::t('shop', 'Are you sure you want to delete this item?'),
                ]
            ],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/shop/order']],
        ];

        return $this->render('view', [
            'order' => $this->findModel($id),
        ]);
    }

    public static function titleUpdate($id)
    {
        return Yii::t('shop', 'Update');
    }

    public function actionUpdate($id)
    {
        $this->nav->title = static::titleUpdate($id);
        $this->nav->crumbs = static::crumbsToOrder();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/shop/order']],
        ];

        $order = $this->findModel($id);

        $form = new OrderEditForm($order);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($order->id, $form);
                return $this->redirect(['view', 'id' => $order->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'order' => $order,
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

    protected function findModel($id): Order
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}