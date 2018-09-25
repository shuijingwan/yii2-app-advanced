<?php

use yii\db\Migration;

/**
 * Class m180925_091558_update_is_deleted_value_and_deleted_at_value_to_user_and_page
 */
class m180925_091558_update_is_deleted_value_and_deleted_at_value_to_user_and_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('{{%user}}', ['is_deleted' => 1, 'status' => 0, 'deleted_at' => time()], ['status' => -1]);
        $this->update('{{%page}}', ['is_deleted' => 1, 'status' => 0, 'deleted_at' => time()], ['status' => -1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180925_091558_update_is_deleted_value_and_deleted_at_value_to_user_and_page cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180925_091558_update_is_deleted_value_and_deleted_at_value_to_user_and_page cannot be reverted.\n";

        return false;
    }
    */
}
