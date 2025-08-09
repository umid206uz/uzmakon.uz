<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rating}}`.
 */
class m201111_213302_create_rating_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rating}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'rating' => $this->integer()->notNull(),
            'username' => $this->string(255)->notNull(),
            'comment' => $this->string(1000)->notNull(),
        ]);
        $this->addForeignKey('product-rating', 'rating', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rating}}');
    }
}
