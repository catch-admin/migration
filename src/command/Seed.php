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

namespace catchAdmin\migration\command;

use catchAdmin\migration\console\Input;
use catchAdmin\migration\console\Output;
use InvalidArgumentException;
use Phinx\Seed\AbstractSeed;
use Phinx\Util\Util;
use catchAdmin\migration\Command;
use catchAdmin\migration\Seeder;

abstract class Seed extends Command
{

    /**
     * @var array
     */
    protected $seeds = [];

    /**
     * @time 2022年01月17日
     * @return string
     */
    protected function getPath(): string
    {
        if ($this->input->hasOption('path')) {
            return $this->app->getRootPath() . $this->input->getOption('path');
        }

        return $this->app->getRootPath() . 'database' . DIRECTORY_SEPARATOR . 'seeds';
    }

    public function getSeeds(): array
    {
        if (empty($this->seeds)) {
            $phpFiles = glob($this->getPath() . DIRECTORY_SEPARATOR . '*.php', defined('GLOB_BRACE') ? GLOB_BRACE : 0);

            // filter the files to only get the ones that match our naming scheme
            $fileNames = [];
            /** @var Seeder[] $seeds */
            $seeds = [];

            foreach ($phpFiles as $filePath) {
                if (Util::isValidSeedFileName(basename($filePath))) {
                    // convert the filename to a class name
                    $class             = pathinfo($filePath, PATHINFO_FILENAME);
                    $fileNames[$class] = basename($filePath);

                    // load the seed file
                    /** @noinspection PhpIncludeInspection */
                    require_once $filePath;
                    if (!class_exists($class)) {
                        throw new InvalidArgumentException(sprintf('Could not find class "%s" in file "%s"', $class, $filePath));
                    }

                    // instantiate it
                    $seed = new $class(new Input($this->input), new Output($this->output));

                    if (!($seed instanceof AbstractSeed)) {
                        throw new InvalidArgumentException(sprintf('The class "%s" in file "%s" must extend \Phinx\Seed\AbstractSeed', $class, $filePath));
                    }

                    $seeds[$class] = $seed;
                }
            }

            ksort($seeds);
            $this->seeds = $seeds;
        }

        return $this->seeds;
    }
}
