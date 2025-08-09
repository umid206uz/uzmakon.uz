<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_charity}}`.
 */
class m211211_205427_create_admin_charity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_charity}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'admin_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_date' => $this->string(255)->notNull(),
            'payed_date' => $this->string(255),
        ]);
        $this->addForeignKey('admin_charity-orders', 'admin_charity', 'order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('admin_charity-user', 'admin_charity', 'admin_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_charity}}');
    }
}
