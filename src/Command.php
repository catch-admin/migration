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

use InvalidArgumentException;
use Phinx\Config\Config;
use Phinx\Db\Adapter\AdapterFactory;
use Phinx\Db\Adapter\AdapterInterface;

abstract class Command extends \think\console\Command
{
    /**
     * @time 2022年01月17日
     * @return AdapterInterface
     */
    public function getAdapter(): AdapterInterface
    {
        if (isset($this->adapter)) {
            return $this->adapter;
        }

        $options = $this->getAdapterConfig();

        $adapter = AdapterFactory::instance()->getAdapter($options['adapter'], $options);

        if ($adapter->hasOption('table_prefix') || $adapter->hasOption('table_suffix')) {
            $adapter = AdapterFactory::instance()->getWrapper('prefix', $adapter);
        }

        $this->adapter = $adapter;

        return $adapter;
    }

    /**
     * @return array
     */
    protected function getAdapterConfig(): array
    {
        $adapterKeys = [
            'adapter' => 'type',
            'host' => 'hostname',
            'name' => 'database',
            'user' => 'username',
            'pass' => 'password',
            'port' => 'hostport',
            'charset' => 'charset',
            'table_prefix' => 'prefix'
        ];

        $defaultConfig = $this->getDefaultDatabase();

        $isDeploy = $this->isDeploy();

        $adapterConfig = [];

        foreach ($adapterKeys as $key => $defaultConfigKey) {
            if ($isDeploy) {
                $adapterConfig[$key] = is_array($defaultConfig[$defaultConfigKey]) ? $defaultConfig[$defaultConfigKey][0] :
                    explode(',', $defaultConfig[$defaultConfigKey])[0];
            } else {
                $adapterConfig[$key] = $defaultConfig[$defaultConfigKey];
            }
        }

        $table = $this->app->config->get('database.migration_table', 'migrations');

        $adapterConfig['default_migration_table'] = $adapterConfig['table_prefix'] . $table;

        // 默认使用版本排序
        $adapterConfig['version_order'] = Config::VERSION_ORDER_CREATION_TIME;

        return $adapterConfig;
    }

    /**
     * 是否分布式部署
     *
     * @time 2022年01月17日
     * @return bool
     */
    protected function isDeploy(): bool
    {
        $config = $this->getDefaultDatabase();

        return isset($config['deploy']) && $config['deploy'] == 1;
    }


    /**
     * get database config
     * @time 2022年01月17日
     * @return array|mixed
     */
    protected function getDefaultDatabase(): array
    {
        $default = $this->app->config->get('database.default');

        return $this->app->config->get("database.connections.{$default}");
    }

    /**
     * @time 2022年01月17日
     * @param string $path
     */
    protected function verifyMigrationDirectory(string $path)
    {
        if (! is_dir($path)) {
            throw new InvalidArgumentException(sprintf('Migration directory "%s" does not exist', $path));
        }

        if (! is_writable($path)) {
            throw new InvalidArgumentException(sprintf('Migration directory "%s" is not writable', $path));
        }
    }
}
