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

use Phinx\Seed\AbstractSeed;
use think\App;

class Seeder extends AbstractSeed
{
    /**
     * @return App|object
     */
    public function factory(): Factory
    {
        return app(Factory::class);
    }
}
