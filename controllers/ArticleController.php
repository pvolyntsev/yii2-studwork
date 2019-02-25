<?php

namespace app\controllers;

use yii;
use app\models\Article;
use app\models\ArticleQuery;
use app\helpers\ArticleSerializer;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

class ArticleController extends \app\components\ActiveController
{
    public $modelClass = Article::class;

    public $guestsActions = [

        /* requirement: доступен всем пользователям, в том числе не аутентифицированным */
        'index',

        /* requirement: доступен всем пользователям, в том числе не аутентифицированным */
        'view',
    ];

    public $serializer = [
        'class' => ArticleSerializer::class,
        'collectionEnvelope' => 'articles',
    ];

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        $actions['update']['scenario'] = 'update';
        $actions['create']['scenario'] = 'create';
        return $actions;
    }

    public function beforeAction($action)
    {
        switch($action->id)
        {
            case 'view':
            case 'create':
            case 'update':
                /* requirement: Каждая заметка должна отображать в end point просмотра заметки: заголовок, текст, дату публикации, информацию об авторе заметки. */
                /* @see ArticleSerializer */
                $this->serializer['fields'] = ['id', 'title', 'text', 'published_at'];
                break;
        }
        return parent::beforeAction($action);
    }


    /**
     * @param string $action
     * @param Article $model
     * @param array $params
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        switch($action)
        {
            case 'index':
                /* End point списка заметок */
                /* @see prepareDataProvider() */
                break;

            case 'view':
                /* End point просмотра заметки */
                /* requirement: не позволяет просматривать заметки с датой публикации в будущем и заметки, которые были удалены. */
                if ($model->author_id !== \Yii::$app->user->id && strtotime($model->published_at) > time())
                    throw new NotFoundHttpException('Err 1');
                if ($model->deleted)
                    throw new NotFoundHttpException('Err 2');
                break;

            case 'create':
                /* End point создания заметки */
                break;

            case 'update':
                /* End point изменения заметки */

                /* requirement: позволяет изменять заметки только их авторам */
                if ($model->author_id !== \Yii::$app->user->id)
                    throw new ForbiddenHttpException('Err 3');

                /* requirement: позволяет изменять только те заметки, которые были созданы менее 24 часов назад. */
                if (strtotime($model->created_at) < strtotime('-24 hours'))
                    throw new UnprocessableEntityHttpException('Err 4');

                /* requirement: не позволяет изменять заметки, которые были удалены. */
                if ($model->deleted)
                    throw new NotFoundHttpException('Err 5');
                break;

            case 'delete':
                /* End point удаления заметки */
                /* requirement: позволяет удалять заметки только их авторам */
                if ($model->author_id !== \Yii::$app->user->id)
                    throw new ForbiddenHttpException('Err 6');

                /* requirement: позволяет удалять только те заметки, которые были созданы менее 24 часов назад. */
                if (strtotime($model->created_at) < strtotime('-24 hours'))
                    throw new UnprocessableEntityHttpException('Err 7');

                /* requirement: не позволяет удалять заметки, которые были удалены. */
                if ($model->deleted)
                    throw new NotFoundHttpException('Err 8');
        }
    }

    /**
     * @param \yii\rest\Action $action
     * @param array $filter
     * @return null|\yii\data\ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function prepareDataProvider($action, $filter)
    {
        $requestParams = Yii::$app->getRequest()->getBodyParams();
        if (empty($requestParams)) {
            $requestParams = Yii::$app->getRequest()->getQueryParams();
        }

        /* @var yii\db\BaseActiveRecord $modelClass */
        /* @var ArticleQuery $query */

        $modelClass = $this->modelClass;
        $query = $modelClass::find();

        if (!empty($filter)) {
            $query->andWhere($filter);
        }

        if (Yii::$app->user->isGuest) {
            $query->forGuests();
        } else {
            $query->forAuthors();
        }

        return Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $query,
            'pagination' => [
                'class' => yii\data\Pagination::class,

                /**
                 * requirement: выводит 5 заметок на каждой странице, изменение этого
                 * параметра пользователем не разрешается; номер страницы
                 * для вывода указывается GET-параметром p;
                 */

                'pageParam' => 'p', // requirement: параметр запроса для указания номера страницы
                'defaultPageSize' => 5, // requirement: количество записей на страницу = 5 штук
                'pageSizeLimit' => false, // requirement: всегда неизменное количество записей на страницу
                'params' => $requestParams,
            ],
        ]);
    }

}