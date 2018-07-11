<?php

use yii\db\Migration;

/**
 * Class m180711_054308_update_status_to_user
 */
class m180711_054308_update_status_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'status', $this->smallInteger(6)->notNull()->defaultValue(1)->comment('状态，-1：删除；0：禁用；1：启用'));
        $this->alterColumn('{{%user}}', 'created_at', $this->integer()->notNull()->defaultValue(0)->comment('创建时间'));
        $this->alterColumn('{{%user}}', 'updated_at', $this->integer()->notNull()->defaultValue(0)->comment('更新时间'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'status', $this->smallInteger(6)->notNull()->defaultValue(10)->comment(''));
        $this->alterColumn('{{%user}}', 'created_at', $this->integer()->notNull()->comment(''));
        $this->alterColumn('{{%user}}', 'updated_at', $this->integer()->notNull()->comment(''));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180711_054308_update_status_to_user cannot be reverted.\n";

        return false;
    }
    */
}
