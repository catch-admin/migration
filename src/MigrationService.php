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

use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use catchAdmin\migration\command\factory\Create as FactoryCreate;
use catchAdmin\migration\command\migrate\Breakpoint as MigrateBreakpoint;
use catchAdmin\migration\command\migrate\Create as MigrateCreate;
use catchAdmin\migration\command\migrate\Rollback as MigrateRollback;
use catchAdmin\migration\command\migrate\Run as MigrateRun;
use catchAdmin\migration\command\migrate\Status as MigrateStatus;
use catchAdmin\migration\command\seed\Create as SeedCreate;
use catchAdmin\migration\command\seed\Run as SeedRun;
use think\Service;

class MigrationService extends Service
{

    public function boot()
    {
        $this->app->bind(FakerGenerator::class, function () {
            return FakerFactory::create($this->app->config->get('app.faker_locale', 'zh_CN'));
        });

        $this->app->bind(Factory::class, function () {
            return (new Factory($this->app->make(FakerGenerator::class)))->load($this->app->getRootPath() . 'database/factories/');
        });

        $this->app->bind('migration.creator', Creator::class);

        $this->commands([
            MigrateCreate::class,
            MigrateRun::class,
            MigrateRollback::class,
            MigrateBreakpoint::class,
            MigrateStatus::class,
            SeedCreate::class,
            SeedRun::class,
            FactoryCreate::class,
        ]);
    }
}
