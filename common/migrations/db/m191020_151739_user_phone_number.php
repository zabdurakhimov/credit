<?php

use yii\db\Migration;

/**
 * Class m191020_151739_user_phone_number
 */
class m191020_151739_user_phone_number extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'phone_number', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'phone_number');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191020_151739_user_phone_number cannot be reverted.\n";

        return false;
    }
    */
}
