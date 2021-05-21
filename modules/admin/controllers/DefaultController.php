<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\modules\admin\components\Navigator;

/**
 * Default controller for the `admin` module
 */
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

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->nav->title = static::titleIndex();
        
        return $this->render('index');
    }
}
