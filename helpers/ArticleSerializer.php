<?php

namespace app\helpers;

use app\models\Article;
use yii\web\Link;

class ArticleSerializer extends \yii\rest\Serializer
{
    /* requirement: Каждая заметка должна отображать во всех end points, кроме просмотра: заголовок, дату публикации, информацию об авторе заметки */
    public $fields = ['id', 'title', 'published_at'];
    public $expand = ['author'];

    /**
     * Serializes a set of Article models
     * @param Article $models
     * @return array the array representation of the models
     */
    protected function serializeModels(array $models)
    {
        foreach ($models as $i => $model)
            $models[$i] = $this->serializeModel($model);
        return $models;
    }

    /**
     * Serializes single Article model
     * @param \app\models\Article $model
     * @return array
     */
    protected function serializeModel($model)
    {
        $result = $model->toArray($this->fields);
        if (in_array('author', $this->expand))
            $result['author'] = $model->author->toArray(['id', 'name']);
        return $result;
    }

    /**
     * Serialize pagination
     * @param \yii\data\Pagination $pagination
     * @return array
     */
    protected function serializePagination($pagination)
    {
        return [
            /*
             * выводит информацию о количестве заметок, количестве
             * страниц и номере текущей страницы как параметры ответа
             * count, pageCount и currentPage соответственно.
             */
            'count' => $pagination->totalCount,
            'pageCount' => $pagination->getPageCount(),
            'currentPage' => $pagination->getPage() + 1,
        ];
    }
}