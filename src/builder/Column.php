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

use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Db\Adapter\MysqlAdapter;

class Column extends \Phinx\Db\Table\Column
{
    /**
     * @var bool
     */
    protected bool $unique = false;

    /**
     * @time 2022年01月14日
     * @param bool $able
     * @return Column
     */
    public function nullable(bool $able = true): Column
    {
        return $this->setNull($able);
    }

    /**
     * @time 2022年01月14日
     * @return Column
     */
    public function unsigned(): Column
    {
        return $this->setSigned(false);
    }

    /**
     * @time 2022年01月14日
     * @return $this
     */
    public function unique(): Column
    {
        $this->unique = true;

        return $this;
    }

    /**
     * @time 2022年01月14日
     * @return bool
     */
    public function getUnique(): bool
    {
        return $this->unique;
    }

    /**
     * @time 2022年01月14日
     * @return bool
     */
    public function isUnique(): bool
    {
        return $this->getUnique();
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @param $type
     * @param array $options
     * @return Column
     */
    public static function make($name, $type, array $options = []): Column
    {
        $column = new self();
        $column->setName($name);
        $column->setType($type);
        $column->setOptions($options);
        return $column;
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function tinyInteger($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_INTEGER, ['length' => MysqlAdapter::INT_TINY]);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function smallInteger($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_INTEGER, ['length' => MysqlAdapter::INT_SMALL]);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function integer($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_INTEGER);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function mediumInteger($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_INTEGER, ['length' => MysqlAdapter::INT_MEDIUM]);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function bigInteger($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_BIG_INTEGER);
    }

    /**
     * @time 2022年01月17日
     * @param string $name
     * @return Column
     */
    public function unsignedTinyInteger(string $name): Column
    {
        return $this->tinyInteger($name)->unsigned();
    }

    /**
     * @time 2022年01月17日
     * @param string $name
     * @return Column
     */
    public function unsignedSmallInteger(string $name): Column
    {
        return $this->smallInteger($name)->unsigned();
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function unsignedInteger($name): Column
    {
        return $this->integer($name)->unsigned();
    }

    /**
     * @time 2022年01月17日
     * @param string $name
     * @return Column
     */
    public function unsignedMediumInteger(string $name): Column
    {
        return $this->mediumInteger($name)->unsigned();
    }

    /**
     * @time 2022年01月17日
     * @param string $name
     * @return Column
     */
    public function unsignedBigInteger(string $name): Column
    {
        return $this->bigInteger($name)->unsigned();
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function binary($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_BLOB);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function boolean($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_BOOLEAN);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @param int $length
     * @return Column
     */
    public function char($name, int $length = 255): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_CHAR, compact('length'));
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function date($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_DATE);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function dateTime($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_DATETIME);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @param int $precision
     * @param int $scale
     * @return Column
     */
    public function decimal($name, int $precision = 8, int $scale = 2): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_DECIMAL, compact('precision', 'scale'));
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @param array $values
     * @return Column
     */
    public function enum($name, array $values): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_ENUM, compact('values'));
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function float($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_FLOAT);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function json($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_JSON);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function jsonb($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_JSONB);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function longText($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_TEXT, ['length' => MysqlAdapter::TEXT_LONG]);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function mediumText($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_TEXT, ['length' => MysqlAdapter::TEXT_MEDIUM]);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @param int $length
     * @return Column
     */
    public function string($name, int $length = 255): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_STRING, compact('length'));
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function text($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_TEXT);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function time($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_TIME);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function timestamp($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_TIMESTAMP);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public function uuid($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_UUID);
    }

    /**
     * @time 2022年01月17日
     * @param $name
     * @return Column
     */
    public function macAddress($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_MACADDR);
    }

    /**
     * @time 2022年01月17日
     * @param $name
     * @return Column
     */
    public function set($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_SET);
    }

    /**
     * ip address
     *
     * @time 2022年01月17日
     * @param $name
     * @param int $length
     * @return Column
     */
    public function ipAddress($name, int $length = 50): Column
    {
        return $this->string($name, $length);
    }

    /**
     * @time 2022年01月17日
     * @param $name
     * @return Column
     */
    public function year($name): Column
    {
        return self::make($name, 'year');
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @param int $precision
     * @param int $scale
     * @return Column
     */
    public function double($name, int $precision = 8, int $scale = 2): Column
    {
        return self::make($name, 'double', compact('precision', 'scale'));
    }

    /**
     * @time 2022年01月17日
     * @param string $deletedAt
     * @param int $default
     * @return Column
     */
    public function softDelete(string $deletedAt = 'delete_at', int $default = 0): Column
    {
        $this->unsignedInteger($deletedAt)->nullable()->default($default)->comment('软删除');

        return $this;
    }

    /**
     * @time 2022年01月17日
     * @param string $createdAt
     * @param int $default
     * @param bool $withTimestamp
     * @return $this
     */
    public function createdAt(string $createdAt = 'created_at', int $default = 0, bool $withTimestamp = false): Column
    {
        if (! $withTimestamp) {
            $this->unsignedInteger($createdAt)->nullable()->default($default)->comment('创建时间');
        } else {
            $this->timestamp($createdAt)->setOptions([
                'default' => $default ? : 'CURRENT_TIMESTAMP',
            ]);
        }
        return $this;
    }

    /**
     * @time 2022年01月17日
     * @param string $updatedAt
     * @param int $default
     * @param bool $withTimestamp
     * @return $this
     */
    public function updatedAt(string $updatedAt = 'updated_at', int $default = 0, bool $withTimestamp = false): Column
    {
        if (! $withTimestamp) {
            $this->unsignedInteger($updatedAt)->nullable()->default($default)->comment('更新时间');
        } else {
            $this->timestamp($updatedAt)->setOptions([
                'null' => true,
                'default' => $default ? : 'CURRENT_TIMESTAMP',
                'update' => $default ? : 'CURRENT_TIMESTAMP',
            ]);
        }

        return $this;
    }

    /**
     * created_at & updated_at
     *
     * @time 2022年01月17日
     * @param string $createdAt
     * @param string $updatedAt
     * @param int $default
     * @param bool $withTimestamp
     */
    public function timestamps(string $createdAt = 'created_at', string $updatedAt = 'updated_at', int $default = 0, bool $withTimestamp = false)
    {
        $this->createdAt($createdAt, $default, $withTimestamp);

        $this->updatedAt($updatedAt, $default, $withTimestamp);
    }

    /**
     * @time 2022年01月17日
     * @param $default
     * @return $this
     */
    public function default($default): Column
    {
        $this->setDefault($default);

        return $this;
    }

    /**
     * @time 2022年01月17日
     * @param $comment
     * @return $this
     */
    public function comment($comment): Column
    {
        $this->setComment($comment);

        return $this;
    }

    /**
     * length
     *
     * @time 2022年01月17日
     * @param int $length
     * @return $this
     */
    public function length(int $length): Column
    {
        $this->setLimit($length);

        return $this;
    }

    /**
     * after
     *
     * @time 2022年01月17日
     * @param string $name
     * @return $this
     */
    public function after(string $name): Column
    {
        $this->setAfter($name);

        return $this;
    }
}
