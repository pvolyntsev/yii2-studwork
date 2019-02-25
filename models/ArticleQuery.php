<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Article]].
 *
 * @see Article
 */
class ArticleQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        /*
         * requirement: выводит заметки, отсортированные по дате публикации в
         * порядке ее убывания; в случае совпадения даты публикаций,
         * первой должна быть выведена заметка, которая была
         * добавлена ранее
         */
        $this->orderBy([
            'published_at' => SORT_ASC,
            'created_at' => SORT_DESC,
        ]);

        /* requirement: не позволяет просматривать заметки, которые были удалены */
        $this->andWhere(['deleted' => 0]);

        parent::init();
    }

    public function forGuests()
    {
        /* requirement: Заметки могут иметь дату публикации в будущем; в этом случае до
         * момента наступления времени публикации они выводятся только
         * их авторам, но не другим пользователям
        */
        return $this->andWhere('published_at IS NOT NULL AND published_at <= :now', [
            'now' => date('c')]
        );
    }

    public function forAuthors($author_id = null)
    {
        /* requirement: Заметки могут иметь дату публикации в будущем; в этом случае до
         * момента наступления времени публикации они выводятся только
         * их авторам, но не другим пользователям
        */

        $author_id = is_null($author_id) ? \Yii::$app->user->id : $author_id;
        return $this->andWhere(
            'author_id = :author_id OR (published_at IS NOT NULL AND published_at <= :now)',
            [
                'now' => date('c'),
                'author_id' => $author_id,
            ]
        );
    }

    /**
     * {@inheritdoc}
     * @return Article[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Article|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
