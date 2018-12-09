<?php

use yii\db\Migration;

/**
 * Class m181209_195259_payment
 */
class m181209_195259_payment extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%payments}}', [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull(),
            'payment_for' => $this->string(150)->notNull(),
            'amount' => $this->integer()->notNull(),
            'status' => $this->string(50)->notNull(),
            'datetime' => $this->dateTime()->notNull(),
            'method' => $this->string(50)->notNull(),
            'payment_type' => $this->string(50)->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%payments}}');
    }
}
