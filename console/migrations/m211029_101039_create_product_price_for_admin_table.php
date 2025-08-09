<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_price_for_admin}}`.
 */
class m211029_101039_create_product_price_for_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_price_for_admin}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'updated_date' => $this->string(255)->notNull(),
            'price' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_price_for_admin}}');
    }
}
