<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m200218_103525_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'title' =>$this->string(255)->notNull(),
            'title_ru' =>$this->string(255)->notNull(),
            'title_en' =>$this->string(255)->notNull(),
            'price' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'description_ru' => $this->text()->notNull(),
            'description_en' => $this->text()->notNull(),
        ]);
        $this->addForeignKey('product-category', 'product', 'category_id', 'category', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
