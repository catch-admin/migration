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

namespace catchAdmin\migration\db;

use catchAdmin\migration\exceptions\TableNotExistException;

class Scheme
{
    /**
     * create a table
     *
     * @time 2022年01月17日
     * @param string $table
     * @param \Closure $create
     */
    public static function create(string $table, \Closure $create)
    {
        $table = new Table($table);

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
    public static function table(string $table, \Closure $update)
    {
        $table = new Table($table);

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
    public static function drop(string $table)
    {
        $table = new Table($table);

        $table->drop();
    }

    /**
     * rename a table
     * @time 2022年01月17日
     * @param string $from
     * @param string $to
     * @throws TableNotExistException
     */
    public static function rename(string $from, string $to)
    {
        $table = new Table($from);

        if (! $table->exists()) {
            throw new TableNotExistException("Table {$table} Not Exists In Database");
        }

        $table->rename($to)->update();
    }
}
