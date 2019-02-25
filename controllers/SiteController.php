<?php

namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'app\components\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return "studwork";
    }
}
