<?php
namespace app\components;

use yii\web\Response;
use yii\rest\ActiveController as BaseActiveController;

class ActiveController extends BaseActiveController
{
    /** @var array List of actions that are exposed for guests */
    public $guestsActions = [];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                // restrict access to hosts/domains
                'Origin' => \Yii::$app->params['cors.origins'],

                // Allow only POST and PUT methods
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE'],

                // Allow only headers 'Authorization'
                'Access-Control-Request-Headers' => ['Authorization','Content-Type'],

                'Access-Control-Allow-Credentials' => true,

                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,

                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                #'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ]
        ];
        $behaviors['authenticator'] = [
            'class' => AccessTokenAuth::class,
            'optional' => $this->guestsActions,
        ];
        return $behaviors;
    }

    public function runAction($id, $params = [])
    {
        if ('OPTIONS' === \Yii::$app->request->getMethod())
            return null;

        return parent::runAction($id, $params);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['error'] = [
            'class' => 'app\components\ErrorAction',
        ];
        return $actions;
    }


}
