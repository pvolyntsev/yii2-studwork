<?php

use yii\db\Migration;

/**
 * Заполнение тестовыми данных таблицы article
 */
class m190224_065931_article_fixture extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /**
         * На момент запуска приложение должно содержать для каждого пользователя как минимум 4 заметки:
         * - 1 заметка с датой создания и публикации в далеком прошлом (т.е. более 24 ч.);
         * - 2 заметки с текущей датой создания и публикации;
         * - 1 заметка с датой публикации в далеком будущем (т.е. более 24 ч.).
         */

        $this->insert('article', [
            'author_id' => 1,
            'title' => 'Старая заметка',
            'text' => 'Заметка создана и опубликована давно',
            'created_at' => date('c', strtotime('-36 hours')),
            'published_at' => date('c', strtotime('-25 hours')),
            'deleted' => 0,
        ]);
        $this->insert('article', [
            'author_id' => 1,
            'title' => 'Заметка 1',
            'text' => 'Заметка создана недавно, опубликована сразу',
            'created_at' => date('c', strtotime('-123 minutes')),
            'published_at' => date('c', strtotime('-123 minutes')),
            'deleted' => 0,
        ]);
        $this->insert('article', [
            'author_id' => 1,
            'title' => 'Заметка 2',
            'text' => 'Заметка создана недавно, опубликована через пару часов',
            'created_at' => date('c', strtotime('-122 minutes')),
            'published_at' => date('c', strtotime('-10 minutes')),
            'deleted' => 0,
        ]);
        $this->insert('article', [
            'author_id' => 1,
            'title' => 'Заметка в будущем',
            'text' => 'Заметка создана сейчас, опубликуется в будущем',
            'created_at' => date('c'),
            'published_at' => date('c', strtotime('+25 hours')),
            'deleted' => 0,
        ]);
        $this->insert('article', [
            'author_id' => 1,
            'title' => 'Заметка удалена',
            'text' => 'Заметка была удалена',
            'created_at' => date('c', strtotime('-140 minutes')),
            'published_at' => date('c', strtotime('-135 minutes')),
            'deleted' => 1,
        ]);

        $this->insert('article', [
            'author_id' => 2,
            'title' => 'Старая заметка',
            'text' => 'Заметка создана и опубликована давно',
            'created_at' => date('c', strtotime('-37 hours')),
            'published_at' => date('c', strtotime('-26 hours')),
        ]);
        $this->insert('article', [
            'author_id' => 2,
            'title' => 'Заметка 1',
            'text' => 'Заметка создана недавно, опубликована сразу',
            'created_at' => date('c', strtotime('-124 minutes')),
            'published_at' => date('c', strtotime('-124 minutes')),
            'deleted' => 0,
        ]);
        $this->insert('article', [
            'author_id' => 2,
            'title' => 'Заметка 2',
            'text' => 'Заметка создана недавно, опубликована через пару часов',
            'created_at' => date('c', strtotime('-123 minutes')),
            'published_at' => date('c', strtotime('-11 minutes')),
            'deleted' => 0,
        ]);
        $this->insert('article', [
            'author_id' => 2,
            'title' => 'Заметка в будущем',
            'text' => 'Заметка создана сейчас, опубликуется в будущем',
            'created_at' => date('c'),
            'published_at' => date('c', strtotime('+26 hours')),
            'deleted' => 0,
        ]);
        $this->insert('article', [
            'author_id' => 2,
            'title' => 'Заметка удалена',
            'text' => 'Заметка была удалена',
            'created_at' => date('c', strtotime('-150 minutes')),
            'published_at' => date('c', strtotime('-145 minutes')),
            'deleted' => 1,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('article', ['author_id' => [1,2]]);
    }
}
