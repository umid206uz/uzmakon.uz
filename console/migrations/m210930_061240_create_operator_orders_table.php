<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operator_orders}}`.
 */
class m210930_061240_create_operator_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operator_orders}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'operator_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_date' => $this->string(255)->notNull(),
            'payed_date' => $this->string(255),
        ]);
        $this->addForeignKey('operator-orders', 'operator_orders', 'order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('operator-orders-user', 'operator_orders', 'operator_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operator_orders}}');
    }
}
