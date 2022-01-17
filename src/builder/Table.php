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

use catchAdmin\migration\exceptions\ColumnCreateFailedException;
use Exception;
use Phinx\Db\Table\Index;
use Phinx\Db\Table as PhinxTable;

/**
 * @method Column string(string $name)
 * @method Column integer(string $name)
 * @method Column mediumInteger(string $name)
 * @method Column bigInteger(string $name)
 * @method Column tinyInteger(string $name)
 * @method Column smallInteger(string $name)
 * @method Column unsignedInteger(string $name)
 * @method Column unsignedTinyInteger(string $name)
 * @method Column unsignedSmallInteger(string $name)
 * @method Column unsignedMediumInteger(string $name)
 * @method Column unsignedBigInteger(string $name)
 * @method Column text(string $name)
 * @method Column time(string $name)
 * @method Column timestamp(string $name)
 * @method Column uuid(string $name)
 * @method Column mediumText(string $name)
 * @method Column longText(string $name)
 * @method Column jsonb(string $name)
 * @method Column json(string $name)
 * @method Column float(string $name)
 * @method Column enum(string $name, array $values)
 * @method Column decimal($name, int $precision = 8, int $scale = 2)
 * @method Column dateTime(string $name)
 * @method Column date(string $name)
 * @method Column char(string $name)
 * @method Column boolean(string $name)
 * @method Column binary(string $name)
 * @method Column softDelete(string $name)
 * @method Column createdAt(string $createdAt = 'created_at', int $default = 0, bool $withTimestamp = false)
 * @method Column updatedAt(string $updatedAt = 'updated_at', int $default = 0, bool $withTimestamp = false)
 * @method Column timestamps(string $createdAt = 'created_at', string $updatedAt = 'updated_at', int $default = 0, bool $withTimestamp = false)
 * @method Column set(string $name)
 * @method Column macAddress(string $name)
 * @method Column ipAddress($name, int $length = 50)
 */
class Table extends PhinxTable
{
    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * 设置id
     * @param string $id
     * @param bool $signed
     * @return $this
     */
    public function id(string $id = 'id', bool $signed = false): Table
    {
        $this->options['id'] = $id;

        $this->options['signed'] = $signed;

        return $this;
    }

    /**
     * @time 2022年01月17日
     * @param string $name
     * @return $this
     */
    public function increment(string $name): Table
    {
        $this->unsignedInteger($name)->setOptions([
            'identity' => true,
        ]);

        return $this;
    }

    /**
     * @time 2022年01月17日
     * @param string $name
     * @return $this
     */
    public function bigIncrement(string $name): Table
    {
        $this->unsignedBigInteger($name)->setOptions([
            'identity' => true,
        ]);

        return $this;
    }

    /**
     * 设置主键
     * @param $key
     * @return $this
     */
    public function primary($key): Table
    {
        $this->options['primary_key'] = $key;

        return $this;
    }

    /**
     * 设置引擎
     * @param string $engine
     * @return $this
     */
    public function engine(string $engine = 'InnoDB'): Table
    {
        $this->options['engine'] = $engine;

        return $this;
    }

    /**
     * 设置表注释
     *
     * @param $comment
     * @return $this
     */
    public function comment($comment): Table
    {
        $this->options['comment'] = $comment;

        return $this;
    }

    /**
     * 设置排序比对方法
     *
     * @param string $collation
     * @return $this
     */
    public function collation(string $collation = 'utf8mb4_general_ci'): Table
    {
        $this->options['collation'] = $collation;

        return $this;
    }

    /**
     * @time 2022年01月17日
     * @param $columnType
     * @param $arguments
     * @return Column
     * @throws ColumnCreateFailedException
     */
    public function __call($columnType, $arguments): Column
    {
        $columnName = $arguments[0];

        switch (count($arguments)) {
            case 1:
                $column = Column::{$columnType}($columnName);
                break;
            case 2:
                $column = Column::{$columnType}($columnName, $arguments[1]);
                break;
            case 3:
                $column = Column::{$columnType}($columnName, $arguments[1], $arguments[2]);
                break;
            case 4:
                $column = Column::{$columnType}($columnName, $arguments[1], $arguments[2], $arguments[3]);
                break;
            default:
                throw new ColumnCreateFailedException("Column {$columnName} create failed, arguments not support");
        }

        $this->columns[] = $column;

        return $column;
    }

    /**
     * @param \Phinx\Db\Table\Column|string $columnName
     * @param null                          $type
     * @param array                         $options
     * @return PhinxTable|Table
     */
    public function addColumn($columnName, $type = null, $options = [])
    {
        if ($columnName instanceof Column && $columnName->getUnique()) {
            $index = new Index();
            $index->setColumns([$columnName->getName()]);
            $index->setType(Index::UNIQUE);
            $this->addIndex($index);
        }

        return parent::addColumn($columnName, $type, $options);
    }

    /**
     * @param string $columnName
     * @param null   $newColumnType
     * @param array  $options
     * @return PhinxTable|Table
     */
    public function changeColumn($columnName, $newColumnType = null, $options = [])
    {
        if ($columnName instanceof Column) {
            return parent::changeColumn($columnName->getName(), $columnName, $options);
        }

        return parent::changeColumn($columnName, $newColumnType, $options);
    }

    /**
     * @time 2022年01月17日
     * @param string|array $name
     * @return $this
     */
    public function index($name, $indexName = null): Table
    {
        $this->addIndex($name, ['name' => $indexName]);

        return $this;
    }

    /**
     * unique index
     *
     * @time 2022年01月17日
     * @param string|array $name
     * @return $this
     */
    public function uniqueIndex($name): Table
    {
        $this->addIndex($name, ['unique' => true]);

        return $this;
    }


    /**
     * morphs
     *
     * @time 2022年01月17日
     * @param $name
     * @param null $indexName
     * @return $this
     */
    public function morphs($name, $indexName = null): Table
    {
        $this->addColumn($this->unsignedInteger("{$name}_id"));

        $this->addColumn($this->string("{$name}_type"));

        $this->index(["{$name}_id", "{$name}_type"], ['name' => $indexName]);

        return $this;
    }

    /**
     * @time 2022年01月17日
     * @param $name
     * @param null $indexName
     * @return $this
     */
    public function nullableMorphs($name, $indexName = null): Table
    {
        $this->addColumn($this->unsignedInteger("{$name}_id")->nullable());

        $this->addColumn($this->string("{$name}_type")->nullable());

        $this->index(["{$name}_id", "{$name}_type"], ['name' => $indexName]);

        return $this;
    }
}
