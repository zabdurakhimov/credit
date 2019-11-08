<?php

use yii\db\Migration;

/**
 * Class m191108_030814_request_favorite
 */
class m191108_030814_request_favorite extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_favorite}}', [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer(),
            'created_by' => $this->integer(),
            'created_at' => $this->integer()
        ]);

        $this->addForeignKey('fk_request_favorite_request', '{{%request_favorite}}', 'request_id', '{{%request}}', 'id', 'no action', 'cascade');
        $this->addForeignKey('fk_request_user_request', '{{%request_favorite}}', 'created_by', '{{%user}}', 'id', 'no action', 'cascade');
        $this->createIndex(

            'idx-unique-request-user',

            'request_favorite',

            'request_id, created_by',

            true

        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_request_favorite_request', '{{%request_favorite}}');
        $this->dropForeignKey('fk_request_user_request', '{{%request_favorite}}');
        $this->dropIndex('idx-unique-request-user', '{{%request_favorite}}');
        $this->dropTable('{{%request_favorite}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191108_030814_request_favorite cannot be reverted.\n";

        return false;
    }
    */
}
