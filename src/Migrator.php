<?php
// +----------------------------------------------------------------------
// | catch-admin [ Just Do it ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 https://catchadmin.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: JaguarJack <njpgper@gmail.com@qq.com>
// +----------------------------------------------------------------------

namespace catchAdmin\migration;

use catchAdmin\migration\exceptions\TableNotExistException;
use Phinx\Migration\AbstractMigration;
use catchAdmin\migration\builder\Table;

class Migrator extends AbstractMigration
{
    /**
     * @param string $tableName
     * @param array $options
     * @return Table
     */
    public function table($tableName, $options = []): Table
    {
        return new Table($tableName, $options, $this->getAdapter());
    }

    /**
     * create a table
     *
     * @time 2022年01月17日
     * @param string $table
     * @param \Closure $create
     */
    public function create(string $table, \Closure $create)
    {
        $table = $this->table($table);

        $create($table);

        $table->create();
    }

    /**
     * update a table
     *
     * @time 2022年01月17日
     * @param string $table
     * @param \Closure $update
     * @throws TableNotExistException
     */
    public function update(string $table, \Closure $update)
    {
        $table = $this->table($table);

        if (! $table->exists()) {
            throw new TableNotExistException("Table {$table} Not Exists In Database");
        }

        $update($table);

        $table->save();
    }

    /**
     * drop a table
     *
     * @time 2022年01月17日
     * @param string $table
     */
    public function drop(string $table)
    {
        $this->table($table)->drop();
    }

    /**
     * rename a table
     * @time 2022年01月17日
     * @param string $from
     * @param string $to
     * @throws TableNotExistException
     */
    public function rename(string $from, string $to)
    {
        $table = $this->table($from);

        if (! $table->exists()) {
            throw new TableNotExistException("Table {$table} Not Exists In Database");
        }

        $table->rename($to)->update();
    }
}
