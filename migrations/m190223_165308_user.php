<?php

use yii\db\Migration;

/**
 * Создание таблицы user для модели app\models\User
 */
class m190223_165308_user extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->comment('Имя пользователя'),
            'access_token' => $this->string(100),
        ]);

        $this->createIndex('uk_acc_tkn', 'user', 'access_token');
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
