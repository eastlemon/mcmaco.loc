<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\modules\admin\components\Navigator;

class DefaultController extends Controller
{
    public $nav;

    public function init()
    {
        parent::init();

        $this->nav = new Navigator();
    }
    
    public static function titleIndex()
    {
        return Yii::t('shop', 'Control');
    }

    public function actionIndex()
    {
        $this->nav->title = static::titleIndex();
        
        return $this->render('index');
    }
}