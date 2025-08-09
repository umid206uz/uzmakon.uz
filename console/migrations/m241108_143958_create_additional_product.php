<?php

use yii\db\Migration;

/**
 * Class m241108_143958_create_additional_product
 */
class m241108_143958_create_additional_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%additional_product}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
            'one_price' => $this->integer()->notNull(),
            'total_price' => $this->integer()->notNull(),
            'created_date' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%additional_product}}');
    }
}
