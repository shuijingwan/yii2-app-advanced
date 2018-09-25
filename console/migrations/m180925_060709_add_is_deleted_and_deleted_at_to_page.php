<?php

use yii\db\Migration;

/**
 * Class m180925_060709_add_is_deleted_and_deleted_at_to_page
 */
class m180925_060709_add_is_deleted_and_deleted_at_to_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%page}}', 'status', $this->smallInteger(6)->notNull()->defaultValue(1)->comment('状态，0：禁用；1：草稿；2：发布'));
        $this->addColumn('{{%page}}', 'is_deleted', $this->smallInteger(6)->notNull()->defaultValue(0)->comment('是否被删除，0：否；1：是')->after('status'));
        $this->addColumn('{{%page}}', 'deleted_at', $this->integer()->notNull()->defaultValue(0)->comment('删除时间')->after('updated_at'));
        $this->dropIndex('uc_uuid', '{{%page}}');
        $this->createIndex('uc_uuid_is_deleted_deleted_at', '{{%page}}', ['uuid', 'is_deleted', 'deleted_at'], $unique = true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180925_060709_add_is_deleted_and_deleted_at_to_page cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180925_060709_add_is_deleted_and_deleted_at_to_page cannot be reverted.\n";

        return false;
    }
    */
}
