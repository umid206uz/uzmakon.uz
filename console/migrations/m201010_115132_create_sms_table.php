<?php

use common\library\sms\models\Sms;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%sms}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m201010_115132_create_sms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sms}}', [
            'id' => $this->primaryKey(),
            'recipient' => $this->string(),
            'message_id' => $this->string(),
            'code' => $this->string(),
            'text' => $this->text(),
            'priority' => $this->string(),
            'status' => $this->string()->defaultValue(Sms::STATUS_NOT_VERIFIED),
            'error_code' => $this->string(),
            'error_description' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-sms-created_by}}',
            '{{%sms}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-sms-created_by}}',
            '{{%sms}}',
            'created_by',
            '{{%user}}',
            'id',
            'SET NULL'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-sms-updated_by}}',
            '{{%sms}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-sms-updated_by}}',
            '{{%sms}}',
            'updated_by',
            '{{%user}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-sms-created_by}}',
            '{{%sms}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-sms-created_by}}',
            '{{%sms}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-sms-updated_by}}',
            '{{%sms}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-sms-updated_by}}',
            '{{%sms}}'
        );

        $this->dropTable('{{%sms}}');
    }
}
