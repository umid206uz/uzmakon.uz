<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%click}}`.
 */
class m210525_064733_create_click_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%click}}', [
            'id' => $this->primaryKey(),
            'stream_id' => $this->integer()->notNull(),
            'date' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%click}}');
    }
}
