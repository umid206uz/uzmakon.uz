<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%black_list}}`.
 */
class m211006_133246_create_black_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%black_list}}', [
            'id' => $this->primaryKey(),
            'phone_number' => $this->string(255),
            'created_date' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%black_list}}');
    }
}
