<?php

use yii\db\Migration;

/**
 * Заполнение тестовыми данных таблицы user
 */
class m190223_165639_user_fixture extends Migration
{
    public function safeUp()
    {
        /*
         * Для упрощения, в базе данных уже должны иметься два
         * пользователя (например, user1 и user2) с зафиксированными
         * Access Tokens.
         */

        $this->insert('user', [
            'id' => 1,
            'name' => 'user1',
            'access_token' => '8591df20-8b33-43fa-85d2-2e918699f3c6',
        ]);

        $this->insert('user', [
            'id' => 2,
            'name' => 'user2',
            'access_token' => '388d1034-2506-43de-bc0b-c6b8c612064c',
        ]);
    }

    public function safeDown()
    {
        $this->delete('user', ['id' => [1, 2]]);
    }
}
