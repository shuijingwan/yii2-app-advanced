<?php

use yii\db\Migration;

/**
 * Class m180807_032326_add_uuid_to_page
 */
class m180807_032326_add_uuid_to_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%page}}', 'uuid', $this->string(64)->notNull()->comment('通用唯一识别码')->after('id'));
        $this->createIndex('uc_uuid', '{{%page}}', 'uuid', $unique = true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%page}}', 'uuid');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180807_032326_add_uuid_to_page cannot be reverted.\n";

        return false;
    }
    */
}
