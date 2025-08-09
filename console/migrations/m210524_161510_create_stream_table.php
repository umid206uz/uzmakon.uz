<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stream}}`.
 */
class m210524_161510_create_stream_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stream}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'oqim_id' => $this->integer()->notNull(),
            'click' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stream}}');
    }
}
