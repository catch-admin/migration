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
     * @return Column
     */
    public function setNullable(): Column
    {
        return $this->setNull(true);
    }

    /**
     * @time 2022年01月14日
     * @return Column
     */
    public function setUnsigned(): Column
    {
        return $this->setSigned(false);
    }

    /**
     * @time 2022年01月14日
     * @return $this
     */
    public function setUnique(): Column
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
    public static function bigInteger($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_BIG_INTEGER);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function binary($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_BLOB);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function boolean($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_BOOLEAN);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @param int $length
     * @return Column
     */
    public static function char($name, int $length = 255): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_CHAR, compact('length'));
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function date($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_DATE);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function dateTime($name): Column
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
    public static function decimal($name, int $precision = 8, int $scale = 2): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_DECIMAL, compact('precision', 'scale'));
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @param array $values
     * @return Column
     */
    public static function enum($name, array $values): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_ENUM, compact('values'));
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function float($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_FLOAT);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function integer($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_INTEGER);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function json($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_JSON);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function jsonb($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_JSONB);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function longText($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_TEXT, ['length' => MysqlAdapter::TEXT_LONG]);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function mediumInteger($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_INTEGER, ['length' => MysqlAdapter::INT_MEDIUM]);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function mediumText($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_TEXT, ['length' => MysqlAdapter::TEXT_MEDIUM]);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function smallInteger($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_INTEGER, ['length' => MysqlAdapter::INT_SMALL]);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @param int $length
     * @return Column
     */
    public static function string($name, int $length = 255): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_STRING, compact('length'));
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function text($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_TEXT);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function time($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_TIME);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function tinyInteger($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_INTEGER, ['length' => MysqlAdapter::INT_TINY]);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function unsignedInteger($name): Column
    {
        return self::integer($name)->setUnSigned();
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function timestamp($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_TIMESTAMP);
    }

    /**
     * @time 2022年01月14日
     * @param $name
     * @return Column
     */
    public static function uuid($name): Column
    {
        return self::make($name, AdapterInterface::PHINX_TYPE_UUID);
    }
}
