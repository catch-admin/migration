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

use Phinx\Db\Table\Index;

class Table extends \Phinx\Db\Table
{
    /**
     * @var array
     */
    protected array $options = [];

    /**
     * 设置id
     * @param $id
     * @return $this
     */
    public function setId($id): Table
    {
        $this->options['id'] = $id;

        return $this;
    }

    /**
     * 设置主键
     * @param $key
     * @return $this
     */
    public function setPrimaryKey($key): Table
    {
        $this->options['primary_key'] = $key;

        return $this;
    }

    /**
     * 设置引擎
     * @param $engine
     * @return $this
     */
    public function setEngine($engine): Table
    {
        $this->options['engine'] = $engine;

        return $this;
    }

    /**
     * 设置表注释
     * @param $comment
     * @return $this
     */
    public function setComment($comment): Table
    {
        $this->options['comment'] = $comment;

        return $this;
    }

    /**
     * 设置排序比对方法
     * @param $collation
     * @return $this
     */
    public function setCollation($collation): Table
    {
        $this->options['collation'] = $collation;

        return $this;
    }

    public function addSoftDelete(): Table
    {
        $this->addColumn(Column::timestamp('delete_time')->setNullable());

        return $this;
    }

    public function addMorphs($name, $indexName = null): Table
    {
        $this->addColumn(Column::unsignedInteger("{$name}_id"));

        $this->addColumn(Column::string("{$name}_type"));

        $this->addIndex(["{$name}_id", "{$name}_type"], ['name' => $indexName]);

        return $this;
    }

    public function addNullableMorphs($name, $indexName = null): Table
    {
        $this->addColumn(Column::unsignedInteger("{$name}_id")->setNullable());

        $this->addColumn(Column::string("{$name}_type")->setNullable());

        $this->addIndex(["{$name}_id", "{$name}_type"], ['name' => $indexName]);

        return $this;
    }

    /**
     * @param string $createdAtColumnName
     * @param string $updatedAtColumnName
     * @return \Phinx\Db\Table|Table
     */
    public function addTimestamps(string $createdAtColumnName = 'create_time', string $updatedAtColumnName = 'update_time')
    {
        return parent::addTimestamps($createdAtColumnName, $updatedAtColumnName);
    }

    /**
     * @param \Phinx\Db\Table\Column|string $columnName
     * @param null                          $type
     * @param array                         $options
     * @return \Phinx\Db\Table|Table
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
     * @return \Phinx\Db\Table|Table
     */
    public function changeColumn($columnName, $newColumnType = null, array $options = [])
    {
        if ($columnName instanceof \Phinx\Db\Table\Column) {
            return parent::changeColumn($columnName->getName(), $columnName, $options);
        }
        return parent::changeColumn($columnName, $newColumnType, $options);
    }
}
