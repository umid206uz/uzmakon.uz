<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%atrcat}}`.
 */
class m200217_100235_create_atrcat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%atrcat}}', [
            'id' => $this->primaryKey(),
            'attribute_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),

        ]);
        $this->addForeignKey('atrcat', 'atrcat', 'attribute_id', 'attribute', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('atrcat1', 'atrcat', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%atrcat}}');
    }
}
