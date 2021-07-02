<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\models\UserSearch;
use shop\entities\User\User;
use shop\forms\manage\User\UserCreateForm;
use shop\forms\manage\User\UserEditForm;
use shop\useCases\manage\UserManageService;
use yii\helpers\Url;
use app\modules\admin\components\Navigator;

class UserController extends Controller
{
    private $service;
    public $nav;

    public function __construct($id, $module, UserManageService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->nav = new Navigator();
    }

    public function behaviors()
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
        return Yii::t('shop', 'Users');
    }

    public static function crumbsToIndex()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],
        ];
    }

    public static function crumbsToUser()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],            
            ['label' => static::titleIndex(), 'url' => ['/admin/user']],
        ];
    }

    public function actionIndex()
    {
        $this->nav->title = static::titleIndex();
        $this->nav->crumbs = static::crumbsToIndex();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => static::titleCreate(), 'url' => ['/admin/user/create']],
        ];

        $searchModel = new UserSearch();
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
        $this->nav->crumbs = static::crumbsToUser();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Update'), 'url' => Url::to(['/admin/user/update', 'id' => $id])],
            ['label' => Yii::t('shop', 'Delete'), 'url' => Url::to(['/admin/user/delete', 'id' => $id]),
                'linkOptions' => [
                    'data-method' => 'POST',
                    'data-confirm' => Yii::t('shop', 'Are you sure you want to delete this item?'),
                ]
            ],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/user']],
        ];

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public static function titleCreate()
    {
        return Yii::t('shop', 'Create');
    }

    public function actionCreate()
    {
        $this->nav->title = static::titleCreate();
        $this->nav->crumbs = static::crumbsToUser();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/user']],
        ];

        $form = new UserCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->create($form);
                return $this->redirect(['view', 'id' => $user->id]);
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
        $this->nav->crumbs = static::crumbsToUser();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/user']],
        ];

        $user = $this->findModel($id);

        $form = new UserEditForm($user);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($user->id, $form);
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}