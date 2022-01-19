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

namespace catchAdmin\migration\command\migrate;

use Phinx\Migration\MigrationInterface;
use think\console\input\Option as InputOption;
use think\console\Input;
use think\console\Output;
use catchAdmin\migration\command\Migrate;

class Rollback extends Migrate
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('migrate:rollback')
             ->setDescription('Rollback the last or to a specific migration')
             ->addOption('--target', '-t', InputOption::VALUE_REQUIRED, 'The version number to rollback to')
             ->addOption('--step', '-s', InputOption::VALUE_REQUIRED, 'The step will to rollback to')
             ->addOption('--force', '-f', InputOption::VALUE_NONE, 'Force rollback to ignore breakpoints')
            ->addOption('--path', '-p', InputOption::VALUE_REQUIRED, 'The path will rollback to')
            ->setHelp(
                 <<<EOT
The <info>migrate:rollback</info> command reverts the last migration, or optionally up to a specific version

<info>php think migrate:rollback</info>
<info>php think migrate:rollback -t 20111018185412</info>
<info>php think migrate:rollback -d 20111018</info>
<info>php think migrate:rollback -v</info>
<info>php think migrate:rollback -p /path</info>
EOT
             );
    }

    /**
     * Rollback the migration.
     *
     * @param Input $input
     * @param Output $output
     * @return void
     * @throws \Exception
     */
    protected function execute(Input $input, Output $output)
    {
        $version = $input->getOption('target');
        $step    = $input->getOption('step');
        $force   = (bool) $input->getOption('force');

        // rollback the specified environment
        $start = microtime(true);
        if (null !== $step) {
            $this->rollbackToStep($step, $force);
        } else {
            $this->rollback($version, $force);
        }
        $end = microtime(true);

        $output->writeln('');
        $output->writeln('<comment>All Done. Took ' . sprintf('%.4fs', $end - $start) . '</comment>');
    }

    /**
     * @time 2022年01月19日
     * @param null $version
     * @param false $force
     */
    protected function rollback($version = null, bool $force = false)
    {
        $migrations = $this->getMigrations();
        $versionLog = $this->getVersionLog();
        $versions   = array_keys($versionLog);

        ksort($migrations);
        sort($versions);

        // Check we have at least 1 migration to revert
         if (empty($versions)) {
            $this->output->error('No migrations to rollback');
            return;
         }

         // 如果没有设置 version，则获取最后一个版本
         if ($version === null) {
             $version = end($versions);
         }

         // migration 中找不到版本
        if ( ! isset($migrations[$version])) {
            $this->output->error("Target version {$version} not found");
            return;
        }

        $migration = $migrations[$version];

        if (isset($versionLog[$migration->getVersion()]) && 0 != $versionLog[$migration->getVersion()]['breakpoint'] && !$force) {
            $this->output->error('Breakpoint reached. Further rollbacks inhibited.');
            return;
        }

        if (in_array($migration->getVersion(), $versions)) {
            $this->executeMigration($migration, MigrationInterface::DOWN);
        } else {
            $this->output->error('Migration Version Not Found');
        }
    }

    /**
     * @time 2022年01月19日
     * @param $step
     * @param false $force
     */
    protected function rollbackToStep($step, bool $force = false)
    {
        $versions   = $this->getVersions();

        sort($versions);

        if (! count($versions)) {
            $this->output->error('No migrations to rollback');
        } else {
            while ($step) {
                $version = end($versions);

                $this->rollback($version, $force);

                $step--;
            }
        }
    }
}
