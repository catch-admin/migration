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

namespace catchAdmin\migration\command\seed;

use Phinx\Util\Util;
use think\console\Input;
use think\console\input\Argument as InputArgument;
use think\console\input\Option as InputOption;
use think\console\Output;
use catchAdmin\migration\command\Seed;

class Create extends Seed
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('make:seed')
            ->setDescription('Create a new database seeder')
            ->addArgument('name', InputArgument::REQUIRED, 'What is the name of the seeder?')
            ->addOption('--path', '-p', InputOption::VALUE_REQUIRED, 'create seed in the path which set')
            ->setHelp(sprintf('%sCreates a new database seeder%s', PHP_EOL, PHP_EOL));
    }

    /**
     * Create the new seeder.
     *
     * @param Input  $input
     * @param Output $output
     * @return void
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    protected function execute(Input $input, Output $output)
    {
        $path = $this->getPath();

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $this->verifyMigrationDirectory($path);

        $path = realpath($path);

        $className = $input->getArgument('name');

        if (!Util::isValidPhinxClassName($className)) {
            throw new \InvalidArgumentException(sprintf('The seed class name "%s" is invalid. Please use CamelCase format', $className));
        }

        // Compute the file path
        $filePath = $path . DIRECTORY_SEPARATOR . $className . '.php';

        if (is_file($filePath)) {
            throw new \InvalidArgumentException(sprintf('The file "%s" already exists', basename($filePath)));
        }

        // inject the class names appropriate to this seeder
        $contents = file_get_contents($this->getTemplate());
        $classes  = [
            'SeederClass' => $className,
        ];
        $contents = strtr($contents, $classes);

        if (false === file_put_contents($filePath, $contents)) {
            throw new \RuntimeException(sprintf('The file "%s" could not be written to', $path));
        }

        $output->writeln('<info>created</info> .' . str_replace(getcwd(), '', $filePath));
    }

    protected function getTemplate()
    {
        return __DIR__ . '/../stubs/seed.stub';
    }
}
