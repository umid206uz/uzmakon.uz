<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%operator_payment}}`.
 */
class m210930_064627_create_operator_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%operator_payment}}', [
            'id' => $this->primaryKey(),
            'operator_id' => $this->integer()->notNull(),
            'amount' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_date' => $this->string(255)->notNull(),
            'payed_date' => $this->string(255),
        ]);
        $this->addForeignKey('operator-payment-user', 'operator_payment', 'operator_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%operator_payment}}');
    }
}
