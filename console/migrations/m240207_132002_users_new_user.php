<?php

use yii\db\Migration;

/**
 * Class m240207_132002_users_new_user
 */
class m240207_132002_users_new_user extends Migration
{
   public function up()
    {
       $this->insert('{{%user}}', [
          'username' => 'developer',
          'auth_key' => '1',
          'password_hash' => 'developer', 
          'email' => 'jas31@yandex.ru',
          'created_at' => '2024-02-07',
          'updated_at' => '2024-02-07',
       ]);
    }

    public function down()
    {
        echo "m240207_132002_users_new_user cannot be reverted.\n";

        return false;
    }
   
}
