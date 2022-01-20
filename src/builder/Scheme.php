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

namespace catchAdmin\migration\builder;

use catchAdmin\migration\exceptions\CreateTableException;
use catchAdmin\migration\exceptions\TableNotExistException;
use catchAdmin\migration\exceptions\UpdateTableException;
use catchAdmin\migration\traits\Adapter;

/**
 * @method static create(string $tableName, \Closure $create)
 * @method static table(string $tableName, \Closure $update)
 * @method static drop(string $tableName)
 * @method static rename(string $from, string $to)
 * @method static dropIfExist(string $from, string $to)
 */
class Scheme
{
    use Adapter;

    /**
     * @time 2022年01月19日
     * @param $name
     * @param array $options
     * @return Table
     */
    protected function getTable($name, array $options = []): Table
    {
        return new Table($name, $options, $this->getAdapter());
    }

    /**
     * create a table
     *
     * @time 2022年01月17日
     * @param string $tableName
     * @param \Closure $create
     * @return bool
     * @throws CreateTableException
     */
    public function _create(string $tableName, \Closure $create): bool
    {
        try {
            $table = $this->getTable($tableName);

            $create($table);

            $table->engine();

            $table->collation();

            $table->create();

            return true;
        } catch (\Exception $e) {
            throw new CreateTableException($e->getMessage());
        }
    }

    /**
     * update a table
     *
     * @time 2022年01月17日
     * @param string $tableName
     * @param \Closure $update
     * @return bool
     * @throws \Exception
     */
    public function _table(string $tableName, \Closure $update): bool
    {
        try {
            $table = $this->getTable($tableName);

            if (!$table->exists()) {
                throw new TableNotExistException("Table {$tableName} Not Exists In Database");
            }

            $update($table);

            $changeColumns = $table->getBuildingColumns();

            /* @var Column $column */
            foreach ($changeColumns as $column) {
                $table->changeColumn($column->getName(), $column->getType(), $column->getOptions());
            }

            return true;
        } catch (\Exception $e) {
            throw new UpdateTableException($e->getMessage());
        }
    }

    /**
     * drop a table
     *
     * @time 2022年01月17日
     * @param string $table
     * @return bool
     */
    public function _drop(string $table): bool
    {
        $this->getTable($table)->drop();

        return true;
    }

    /**
     * @time 2022年01月19日
     * @param string $table
     * @return bool
     */
    public function _dropIfExist(string $table): bool
    {
        if ($this->getTable($table)->exists()) {
            $this->getTable($table)->drop();
        }

        return true;
    }

    /**
     * rename a table
     * @time 2022年01月17日
     * @param string $from
     * @param string $to
     * @return bool
     * @throws TableNotExistException
     */
    public function _rename(string $from, string $to): bool
    {
        $table = $this->getTable($from);

        if (! $table->exists()) {
            throw new TableNotExistException("Table {$from} Not Exists In Database");
        }

        $table->rename($to)->update();

        return true;
    }

    /**
     * @desc static visit
     *
     * @time 2022年01月19日
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
       return (new self)->{'_' . $name}(...$arguments);
    }
}
