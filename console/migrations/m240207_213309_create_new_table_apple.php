<?php

use yii\db\Migration;

/**
 * Class m240207_213309_create_new_table_apple
 */
class m240207_213309_create_new_table_apple extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string()->notNull()->defaultValue('green'), //цвет яблока
            'status' => $this->smallInteger()->notNull()->defaultValue(1), //1 - висит на дереве, 2 - упало, 3 - сгнило
            'balance' => $this->integer()->notNull()->defaultValue(100), // сколько осталось от целого яблока в процентах
            'created_at' => $this->timestamp()->notNull(), // дата появления
            'fall_at' => $this->timestamp()->defaultValue(NULL), // дата падения
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%apple}}');
    }
    
}
