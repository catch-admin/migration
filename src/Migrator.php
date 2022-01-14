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

use Phinx\Migration\AbstractMigration;
use catchAdmin\migration\db\Table;

class Migrator extends AbstractMigration
{
    /**
     * @param string $tableName
     * @param array  $options
     * @return Table
     */
    public function table($tableName, $options = []): Table
    {
        return new Table($tableName, $options, $this->getAdapter());
    }
}
