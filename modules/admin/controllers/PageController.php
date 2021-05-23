<?php

namespace app\modules\admin\controllers;

use shop\forms\manage\PageForm;
use shop\useCases\manage\PageManageService;
use Yii;
use shop\entities\Page;
use app\modules\admin\models\PageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\modules\admin\components\Navigator;

class PageController extends Controller
{
    private $service;
    public $nav;

    public function __construct($id, $module, PageManageService $service, $config = [])
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
        return Yii::t('shop', 'Pages');
    }

    public static function crumbsToIndex()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],
        ];
    }

    public static function crumbsToPage()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],            
            ['label' => static::titleIndex(), 'url' => ['/admin/page']],
        ];
    }

    public function actionIndex()
    {
        $this->nav->title = static::titleIndex();
        $this->nav->crumbs = static::crumbsToIndex();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => static::titleCreate(), 'url' => ['/admin/page/create']],
        ];

        $searchModel = new PageSearch();
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
        $this->nav->crumbs = static::crumbsToPage();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Update'), 'url' => Url::to(['/admin/page/update', 'id' => $id])],
            ['label' => Yii::t('shop', 'Delete'), 'url' => Url::to(['/admin/page/delete', 'id' => $id]),
                'linkOptions' => [
                    'data-method' => 'POST',
                    'data-confirm' => Yii::t('shop', 'Are you sure you want to delete this item?'),
                ]
            ],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/page']],
        ];

        return $this->render('view', [
            'page' => $this->findModel($id),
        ]);
    }
    
    public static function titleCreate()
    {
        return Yii::t('shop', 'Create');
    }

    public function actionCreate()
    {
        $this->nav->title = static::titleCreate();
        $this->nav->crumbs = static::crumbsToPage();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/page']],
        ];

        $form = new PageForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $page = $this->service->create($form);
                return $this->redirect(['view', 'id' => $page->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public static function titleUpdate()
    {
        return Yii::t('shop', 'Update');
    }

    public function actionUpdate($id)
    {
        $this->nav->title = static::titleUpdate();
        $this->nav->crumbs = static::crumbsToPage();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/page']],
        ];

        $page = $this->findModel($id);

        $form = new PageForm($page);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($page->id, $form);
                return $this->redirect(['view', 'id' => $page->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'page' => $page,
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

    public function actionMoveUp($id)
    {
        $this->service->moveUp($id);
        return $this->redirect(['index']);
    }

    public function actionMoveDown($id)
    {
        $this->service->moveDown($id);
        return $this->redirect(['index']);
    }

    protected function findModel($id): Page
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}