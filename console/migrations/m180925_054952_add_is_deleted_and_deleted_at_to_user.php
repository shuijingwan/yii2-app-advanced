<?php

use yii\db\Migration;

/**
 * Class m180925_054952_add_is_deleted_and_deleted_at_to_user
 */
class m180925_054952_add_is_deleted_and_deleted_at_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'status', $this->smallInteger(6)->notNull()->defaultValue(1)->comment('状态，0：禁用；1：启用'));
        $this->addColumn('{{%user}}', 'is_deleted', $this->smallInteger(6)->notNull()->defaultValue(0)->comment('是否被删除，0：否；1：是')->after('status'));
        $this->addColumn('{{%user}}', 'deleted_at', $this->integer()->notNull()->defaultValue(0)->comment('删除时间')->after('updated_at'));
        $this->dropIndex('username', '{{%user}}');
        $this->dropIndex('email', '{{%user}}');
        $this->createIndex('uc_username_is_deleted_deleted_at', '{{%user}}', ['username', 'is_deleted', 'deleted_at'], $unique = true);
        $this->createIndex('uc_email_is_deleted_deleted_at', '{{%user}}', ['email', 'is_deleted', 'deleted_at'], $unique = true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180925_054952_add_is_deleted_and_deleted_at_to_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180925_054952_add_is_deleted_and_deleted_at_to_user cannot be reverted.\n";

        return false;
    }
    */
}
