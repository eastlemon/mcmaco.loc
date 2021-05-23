<?php
namespace app\modules\admin\controllers;

use yii\web\Controller;
use Yii;
use app\modules\admin\components\Navigator;

class FileController extends Controller
{
    public $nav;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->nav = new Navigator();
    }

    public static function titleIndex()
    {
        return Yii::t('shop', 'Files');
    }

    public static function crumbsToIndex()
    {
        return [
            ['label' => Yii::t('shop', 'Control'), 'url' => ['/admin']],
        ];
    }

    public function actionIndex()
    {
        $this->nav->title = static::titleIndex();
        $this->nav->crumbs = static::crumbsToIndex();

        return $this->render('index');
    }
}
