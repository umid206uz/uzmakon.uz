<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%catpro}}`.
 */
class m200226_115345_create_catpro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catpro}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('catpro-category', 'catpro', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('catpro-product', 'catpro', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%catpro}}');
    }
}
