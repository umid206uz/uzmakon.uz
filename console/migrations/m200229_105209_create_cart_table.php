<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cart}}`.
 */
class m200229_105209_create_cart_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull()
        ]);
        $this->addForeignKey('cart-user', 'cart', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('cart-product', 'cart', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cart}}');
    }
}
