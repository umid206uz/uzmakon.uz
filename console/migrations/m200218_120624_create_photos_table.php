<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%photos}}`.
 */
class m200218_120624_create_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%photos}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'filename' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%photos}}');
    }
}
