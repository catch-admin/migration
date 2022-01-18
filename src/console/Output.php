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

namespace catchAdmin\migration\console;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Output implements OutputInterface
{
    /**
     * @var \think\console\Output
     */
    protected $output;

    public function __construct($output)
    {
        $this->output = $output;
    }

    public function write($messages, $newline = false, $options = 0)
    {
        // TODO: Implement write() method.
        $this->output->write($messages, $newline, $options);
    }

    public function writeln($messages, $options = 0)
    {
        // TODO: Implement writeln() method.
        $this->output->warning($messages);
    }

    public function setVerbosity($level)
    {
        // TODO: Implement setVerbosity() method.
        $this->output->setVerbosity($level);
    }

    public function getVerbosity()
    {
        // TODO: Implement getVerbosity() method.
        return $this->getVerbosity();
    }

    public function isQuiet()
    {
        // TODO: Implement isQuiet() method.
        return $this->output->isQuiet();
    }

    public function isVerbose()
    {
        // TODO: Implement isVerbose() method.
        return $this->output->isVerbose();
    }

    public function isVeryVerbose()
    {
        // TODO: Implement isVeryVerbose() method.
        return $this->output->isVeryVerbose();
    }

    public function isDebug()
    {
        // TODO: Implement isDebug() method.
        return $this->output->isDebug();
    }

    public function setDecorated($decorated)
    {
        // TODO: Implement setDecorated() method.
        $this->output->setDecorated($decorated);
    }

    public function isDecorated()
    {
        // TODO: Implement isDecorated() method.
    }

    public function setFormatter(OutputFormatterInterface $formatter)
    {
        // TODO: Implement setFormatter() method.

    }

    public function getFormatter()
    {
        // TODO: Implement getFormatter() method.

    }
}
