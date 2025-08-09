<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%brand}}`.
 */
class m200224_124313_create_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%brand}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'name_ru' => $this->string(255)->notNull(),
            'name_en' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%brand}}');
    }
}
