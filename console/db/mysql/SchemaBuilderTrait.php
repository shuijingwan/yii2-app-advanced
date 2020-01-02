<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace console\db\mysql;

use yii\base\NotSupportedException;
use yii\db\Connection;
use yii\db\ColumnSchemaBuilder;

/**
 * SchemaBuilderTrait contains shortcut methods to create instances of [[ColumnSchemaBuilder]].
 *
 * These can be used in database migrations to define database schema types using a PHP interface.
 * This is useful to define a schema in a DBMS independent way so that the application may run on
 * different DBMS the same way.
 *
 * For example you may use the following code inside your migration files:
 *
 * ```php
 * $this->createTable('example_table', [
 *   'id' => $this->primaryKey(),
 *   'name' => $this->string(64)->notNull(),
 *   'type' => $this->integer()->notNull()->defaultValue(10),
 *   'description' => $this->text(),
 *   'rule_name' => $this->string(64),
 *   'data' => $this->text(),
 *   'created_at' => $this->datetime()->notNull(),
 *   'updated_at' => $this->datetime(),
 * ]);
 * ```
 *
 * @author Qiang Wang <shuijingwanwq@163.com>
 * @since 1.0
 */
trait SchemaBuilderTrait
{
    /**
     * @return Connection the database connection to be used for schema building.
     */
    abstract protected function getDb();

    /**
     * Creates a tinytext column.
     * @return ColumnSchemaBuilder the column instance which can be further customized.
     * @throws NotSupportedException if there is no support for the current driver type
     * @since 2.0.6
     */
    public function tinyText()
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('tinytext');
    }

    /**
     * Creates a mediumtext column.
     * @return ColumnSchemaBuilder the column instance which can be further customized.
     * @throws NotSupportedException if there is no support for the current driver type
     * @since 2.0.6
     */
    public function mediumText()
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext');
    }

    /**
     * Creates a longtext column.
     * @return ColumnSchemaBuilder the column instance which can be further customized.
     * @throws NotSupportedException if there is no support for the current driver type
     * @since 2.0.6
     */
    public function longText()
    {
        return $this->getDb()->getSchema()->createColumnSchemaBuilder('longtext');
    }
}
