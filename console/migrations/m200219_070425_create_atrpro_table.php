<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%atrpro}}`.
 */
class m200219_070425_create_atrpro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%atrpro}}', [
            'id' => $this->primaryKey(),
            'attribute_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('atrpro-attribute', 'atrpro', 'attribute_id', 'attribute', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('atrpro-product', 'atrpro', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%atrpro}}');
    }
}
