<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%country_delivery_price}}`.
 */
class m211014_132258_create_country_delivery_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%country_delivery_price}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(255)->notNull(),
            'tashkent_city' => $this->integer(255)->notNull(),
            'tashkent_region' => $this->integer(255)->notNull(),
            'bukhara' => $this->integer(255)->notNull(),
            'navoi' => $this->integer(255)->notNull(),
            'samarkand' => $this->integer(255)->notNull(),
            'jizzakh' => $this->integer(255)->notNull(),
            'andijan' => $this->integer(255)->notNull(),
            'fergana' => $this->integer(255)->notNull(),
            'namangan' => $this->integer(255)->notNull(),
            'syrdarya' => $this->integer(255)->notNull(),
            'karakalpakstan' => $this->integer(255)->notNull(),
            'khorezm' => $this->integer(255)->notNull(),
            'kashkadarya' => $this->integer(255)->notNull(),
            'surkhandarya' => $this->integer(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%country_delivery_price}}');
    }
}
