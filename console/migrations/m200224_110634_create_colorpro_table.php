<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%colorpro}}`.
 */
class m200224_110634_create_colorpro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%colorpro}}', [
            'id' => $this->primaryKey(),
            'color_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);
        $this->addForeignKey('colorpro-color', 'colorpro', 'color_id', 'color', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('colorpro-product', 'colorpro', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%colorpro}}');
    }
}
