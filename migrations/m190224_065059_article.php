<?php

use yii\db\Migration;

/**
 * Создание таблицы article для модели app\models\Article
 */
class m190224_065059_article extends Migration
{
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull()->comment('Автор'),
            'title' => $this->string(100)->comment('Заголовок'),
            'text' => $this->text()->comment('Текст'),
            'created_at' => $this->dateTime()->notNull()->comment('Дата создания'),
            'published_at' => $this->dateTime()->notNull()->comment('Дата публикации'),
            'deleted' => $this->smallInteger()->notNull()->defaultValue(0)->comment('Признак удаления'),
        ]);

        $this->addForeignKey('fk_author', 'article', 'author_id', 'user', 'id');
        $this->createIndex('idx_published', 'article', ['published_at', 'created_at', 'deleted']);
    }

    public function down()
    {
        $this->dropTable('article');
    }
}
