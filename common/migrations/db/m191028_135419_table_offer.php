<?php

use yii\db\Migration;

/**
 * Class m191028_135419_table_offer
 */
class m191028_135419_table_offer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%offer}}', [
            'id' => $this->primaryKey(),
            'initial_pay' => $this->double(),
            'total_pay' => $this->double(),
            'period' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer()
        ]);

        $this->addForeignKey('fk_offer_user',
            '{{%offer}}',
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
        $this->dropTable('{{%offer}}');
        $this->dropTable('{{%fk_offer_user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191028_135419_table_offer cannot be reverted.\n";

        return false;
    }
    */
}
