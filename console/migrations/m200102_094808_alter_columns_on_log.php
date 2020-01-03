<?php

use console\db\mysql\SchemaBuilderTrait;
use yii\base\NotSupportedException;
use yii\db\Migration;

/**
 * Class m200102_094808_alter_columns_on_log
 */
class m200102_094808_alter_columns_on_log extends Migration
{
    use SchemaBuilderTrait;

    /**
     * {@inheritdoc}
     * @throws NotSupportedException if there is no support for the current driver type
     */
    public function safeUp()
    {
        $this->alterColumn('{{%log}}', 'prefix', $this->mediumText());
        $this->alterColumn('{{%log}}', 'message', $this->mediumText());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200102_094808_alter_columns_on_log cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200102_094808_alter_columns_on_log cannot be reverted.\n";

        return false;
    }
    */
}
