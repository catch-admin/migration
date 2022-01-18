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
use Phinx\Util\Util;
use RuntimeException;
use think\App;

class Creator
{

    protected App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * @time 2022年01月17日
     * @param string $className
     * @param string $path
     * @return string
     */
    public function create(string $className, string $path = ''): string
    {
        $path = $this->ensureDirectory($path);

        if (! Util::isValidPhinxClassName($className)) {
            throw new InvalidArgumentException(sprintf('The migration class name "%s" is invalid. Please use CamelCase format.', $className));
        }

        if (! Util::isUniqueMigrationClassName($className, $path)) {
            throw new InvalidArgumentException(sprintf('The migration class name "%s" already exists', $className));
        }

        // Compute the file path
        $fileName = Util::mapClassNameToFileName($className);
        $filePath = $path . DIRECTORY_SEPARATOR . $fileName;

        if (is_file($filePath)) {
            throw new InvalidArgumentException(sprintf('The file "%s" already exists', $filePath));
        }

        // Load the alternative template if it is defined.
        $contents = file_get_contents($this->getTemplate());

        // inject the class names appropriate to this migration
        $contents = strtr($contents, [
            'MigratorClass' => $className,
        ]);

        if (false === file_put_contents($filePath, $contents)) {
            throw new RuntimeException(sprintf('The file "%s" could not be written to', $path));
        }

        return $filePath;
    }

    /**
     * @time 2022年01月17日
     * @param string $path
     * @return string
     */
    protected function ensureDirectory(string $path): string
    {
        $path = $this->app->getRootPath() . ($path ? : 'database' . DIRECTORY_SEPARATOR . 'migrations');

        if (!is_dir($path) && !mkdir($path, 0755, true)) {
            throw new InvalidArgumentException(sprintf('directory "%s" does not exist', $path));
        }

        if (!is_writable($path)) {
            throw new InvalidArgumentException(sprintf('directory "%s" is not writable', $path));
        }

        return $path;
    }

    /**
     * @time 2022年01月17日
     * @return string
     */
    protected function getTemplate(): string
    {
        return __DIR__ . '/command/stubs/migrate.stub';
    }
}
