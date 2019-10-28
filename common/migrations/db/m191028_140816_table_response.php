<?php

use yii\db\Migration;

/**
 * Class m191028_140816_table_response
 */
class m191028_140816_table_response extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%response}}', [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer(),
            'status' => $this->integer(),
            'offer_id' => $this->integer(),
            'created_by' => $this->integer(),
            'created_at' => $this->integer(),
        ]);
        $this->addForeignKey('fk_response_offer',
            '{{%response}}',
            'offer_id',
            '{{%offer}}',
            'id',
            'restrict',
            'cascade');

        $this->addForeignKey('fk_response_user',
            '{{%response}}',
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
        $this->dropForeignKey('fk_response_offer', '{{%response}}');
        $this->dropForeignKey('fk_response_user', '{{%response}}');


    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191028_140816_table_response cannot be reverted.\n";

        return false;
    }
    */
}
