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

use InvalidArgumentException;
use RuntimeException;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument as InputArgument;
use think\console\input\Option as InputOption;
use think\console\Output;
use catchAdmin\migration\Creator;

class Create extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('migrate:create')
            ->setDescription('Create a new migration')
            ->addArgument('name', InputArgument::REQUIRED, 'What is the name of the migration?')
            ->addOption('--path', '-p', InputOption::VALUE_REQUIRED, 'create in the path which set')
            ->setHelp(sprintf('%sCreates a new database migration%s', PHP_EOL, PHP_EOL));
    }

    /**
     * Create the new migration.
     *
     * @param Input  $input
     * @param Output $output
     * @return void
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    protected function execute(Input $input, Output $output)
    {
        /** @var Creator $creator */
        $creator = $this->app->get('migration.creator');

        $className = $input->getArgument('name');

        $path = $creator->create($className, $this->input->getOption('path'));

        $output->writeln('<info>created</info> .' . str_replace(getcwd(), '', realpath($path)));
    }

}
