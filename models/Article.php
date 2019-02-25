<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property int $author_id Автор
 * @property string $title Заголовок
 * @property string $text Текст
 * @property string $created_at Дата создания
 * @property string $published_at Дата публикации
 * @property int $deleted Признак удаления
 *
 * @property User $author
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            /* Значения по умолчанию для новой записи: создана сейчас, относится к текущему пользователю, не удалена */
            ['created_at', 'default', 'value' => date('c'), 'on' => 'create'],
            ['author_id', 'default', 'value' => Yii::$app->user->id, 'on' => 'create'],
            ['deleted', 'default', 'value' => 0, 'on' => 'create'],

            [['author_id', 'created_at', 'published_at', 'deleted'], 'required'],
            [['author_id', 'deleted'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 100],
            ['deleted', 'in', 'range' => [0, 1]],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],

            [['title', 'text', 'published_at'], 'safe', 'on' => ['update', 'create']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'created_at' => 'Дата создания',
            'published_at' => 'Дата публикации',
            'deleted' => 'Признак удаления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * {@inheritdoc}
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }

    /**
     * Помечает запись как удалённую без физического удаления
     * @return bool|false|int
     */
    public function delete()
    {
        $this->deleted = 1;
        return parent::save();
    }
}
