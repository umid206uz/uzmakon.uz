<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%oqim}}`.
 */
class m210524_094048_create_oqim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%oqim}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'key' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%oqim}}');
    }
}
