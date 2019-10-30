<?php

use yii\db\Migration;

/**
 * Class m191030_135913_request_attachment
 */
class m191030_135913_request_attachment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_attachment}}', [
            'id' => $this->primaryKey(),
            'request_id' => $this->integer(),
            'order' => $this->integer(),
            'path' => $this->string(),
            'base_url' => $this->string(),
            'created_at' => $this->integer()
        ]);

        $this->addForeignKey('fk_request_attachment_request', '{{%request_attachment}}', 'request_id', '{{%request}}', 'id', 'restrict', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_request_attachment_request', '{{%request_attachment}}');
        $this->dropTable('{{%request_attachment}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191030_135913_request_attachment cannot be reverted.\n";

        return false;
    }
    */
}
