<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%color}}`.
 */
class m200224_110432_create_color_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%color}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'code' => $this->string(255)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%color}}');
    }
}
