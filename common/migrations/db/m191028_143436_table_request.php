<?php

use yii\db\Migration;

/**
 * Class m191028_143436_table_request
 */
class m191028_143436_table_request extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'type' => $this->integer(),
            'accepted_response_id' => $this->integer(),
            'status' => $this->integer(),
            'offer_id' => $this->integer(),
            'description_short' => $this->string(256),
            'description_long' => $this->text(),
            'created_by' => $this->integer(),
            'created_at' => $this->integer(),
        ]);

        $this->addForeignKey('fk_offer',
            '{{%request}}',
            'offer_id',
            '{{%offer}}',
            'id',
            'restrict',
            'cascade');

        $this->addForeignKey('fk_request_category',
            '{{%request}}',
            'category_id',
            '{{%category}}',
            'id',
            'restrict',
            'cascade');

        $this->addForeignKey('fk_request_response',
            '{{%request}}',
            'accepted_response_id',
            '{{%response}}',
            'id',
            'restrict',
            'cascade');

        $this->addForeignKey('fk_response_request',
            '{{%response}}',
            'request_id',
            '{{%request}}',
            'id',
            'restrict',
            'cascade');

        $this->addForeignKey('fk_request_user',
            '{{%request}}',
            'created_by',
            '{{%user}}',
            'id',
            'restrict',
            'cascade');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%response}}');
        $this->dropForeignKey('fk_offer', '{{%request}}');
        $this->dropForeignKey('fk_request_category', '{{%request}}');
        $this->dropForeignKey('fk_request_response', '{{%request}}');
        $this->dropForeignKey('fk_response_request', '{{%response}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191028_143436_table_request cannot be reverted.\n";

        return false;
    }
    */
}
