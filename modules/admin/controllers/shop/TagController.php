<?php

namespace app\modules\admin\controllers\shop;

use shop\forms\manage\Shop\TagForm;
use shop\useCases\manage\Shop\TagManageService;
use Yii;
use shop\entities\Shop\Tag;
use app\modules\admin\models\Shop\TagSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use app\modules\admin\components\Navigator;

class TagController extends Controller
{
    private $service;
    public $nav;

    public function __construct($id, $module, TagManageService $service, $config = [])
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
        return Yii::t('shop', 'Tags');
    }

    public static function crumbsToIndex()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],
        ];
    }

    public static function crumbsToTag()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],            
            ['label' => static::titleIndex(), 'url' => ['/admin/shop/tag']],
        ];
    }

    public function actionIndex()
    {
        $this->nav->title = static::titleIndex();
        $this->nav->crumbs = static::crumbsToIndex();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => static::titleCreate(), 'url' => ['/admin/shop/tag/create']],
        ];

        $searchModel = new TagSearch();
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
        $this->nav->crumbs = static::crumbsToTag();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Update'), 'url' => Url::to(['shop/tag/update', 'id' => $id])],
            ['label' => Yii::t('shop', 'Delete'), 'url' => Url::to(['shop/tag/delete', 'id' => $id]),
                'linkOptions' => [
                    'data-method' => 'POST',
                    'data-confirm' => Yii::t('shop', 'Are you sure you want to delete this item?'),
                ]
            ],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/shop/tag']],
        ];

        return $this->render('view', [
            'tag' => $this->findModel($id),
        ]);
    }

    public static function titleCreate()
    {
        return Yii::t('shop', 'Create');
    }

    public function actionCreate()
    {
        $this->nav->title = static::titleCreate();
        $this->nav->crumbs = static::crumbsToTag();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/shop/tag']],
        ];

        $form = new TagForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $tag = $this->service->create($form);
                return $this->redirect(['view', 'id' => $tag->id]);
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
        $this->nav->crumbs = static::crumbsToTag();
        $this->nav->menuRight = [
            ['label' => Yii::t('shop', 'Options')],
            ['label' => Yii::t('shop', 'Cancel'), 'url' => ['/admin/shop/tag']],
        ];

        $tag = $this->findModel($id);

        $form = new TagForm($tag);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($tag->id, $form);
                return $this->redirect(['view', 'id' => $tag->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'tag' => $tag,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
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

    /**
     * @param integer $id
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Tag
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
