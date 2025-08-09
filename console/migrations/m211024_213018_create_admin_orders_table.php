<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_orders}}`.
 */
class m211024_213018_create_admin_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%admin_orders}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'admin_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_date' => $this->string(255)->notNull(),
            'payed_date' => $this->string(255),
        ]);
        $this->addForeignKey('admin-orders', 'admin_orders', 'order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('admin-orders-user', 'admin_orders', 'admin_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_orders}}');
    }
}
