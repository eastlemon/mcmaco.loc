<?php
namespace app\modules\admin\controllers;

use yii\web\Controller;

class FileController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
