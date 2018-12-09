<?php

use yii\db\Migration;

/**
 * Class m181209_194543_bonus
 */
class m181209_194543_bonus extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%bonus}}', [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'type' => $this->string(255)->notNull(),
            'value' => $this->string(255)->notNull(),
            'datetime' => $this->dateTime()->notNull(),
            'status' => $this->string(25)->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%bonus}}');
    }
}
