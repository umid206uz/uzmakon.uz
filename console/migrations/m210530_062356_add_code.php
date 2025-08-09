<?php

use yii\db\Migration;

/**
 * Class m210530_062356_add_code
 */
class m210530_062356_add_code extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\User::tableName(), 'code', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210530_062356_add_code cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210530_062356_add_code cannot be reverted.\n";

        return false;
    }
    */
}
