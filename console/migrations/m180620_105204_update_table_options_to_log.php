<?php

use yii\db\Migration;

/**
 * Class m180620_105204_update_table_options_to_log
 */
class m180620_105204_update_table_options_to_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            $this->execute('ALTER TABLE {{%user}} CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
            $this->execute('ALTER TABLE {{%log}} CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        }

        $this->addCommentOnTable('{{%user}}', '用户', $tableOptions);
        $this->addCommentOnTable('{{%log}}', '日志', $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180620_105204_update_table_options_to_log cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180620_105204_update_table_options_to_log cannot be reverted.\n";

        return false;
    }
    */
}
