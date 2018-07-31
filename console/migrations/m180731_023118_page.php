<?php

use yii\db\Migration;

/**
 * Class m180731_023118_page
 */
class m180731_023118_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB COMMENT="页面"';
        }

        $this->createTable('{{%page}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull()->comment('别名'),
            'title' => $this->string(255)->notNull()->comment('标题'),
            'body' => $this->text()->notNull()->comment('内容'),
            'view' => $this->integer()->notNull()->defaultValue(0)->comment('浏览'),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('状态，-1：删除；0：禁用；1：草稿；2：发布'),
            'created_at' => $this->integer()->notNull()->defaultValue(0)->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)->comment('更新时间'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%page}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180731_023118_page cannot be reverted.\n";

        return false;
    }
    */
}
