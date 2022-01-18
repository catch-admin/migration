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

use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;

class Input implements InputInterface
{
    /**
     * @var \think\console\Input
     */
    protected $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function getOption($name)
    {
        // TODO: Implement getOption() method.
        return $this->input->getOption($name);
    }

    public function getFirstArgument()
    {
        // TODO: Implement getFirstArgument() method.
        return $this->input->getFirstArgument();
    }

    public function hasParameterOption($values, $onlyParams = false)
    {
        // TODO: Implement hasParameterOption() method.
        return $this->input->hasParameterOption($values);
    }

    public function getParameterOption($values, $default = false, $onlyParams = false)
    {
        // TODO: Implement getParameterOption() method.
        return $this->input->getParameterOption($values);
    }

    public function bind(InputDefinition $definition)
    {
        // TODO: Implement bind() method.
        $this->input->bind($definition);
    }

    public function validate()
    {
        // TODO: Implement validate() method.
        $this->input->validate();
    }

    public function getArguments()
    {
        // TODO: Implement getArguments() method.
        return $this->input->getArguments();
    }

    public function getArgument($name)
    {
        // TODO: Implement getArgument() method.
        return $this->getArgument($name);
    }

    public function setArgument($name, $value)
    {
        // TODO: Implement setArgument() method.
        $this->input->setArgument($name, $value);
    }

    public function hasArgument($name)
    {
        // TODO: Implement hasArgument() method.
        return $this->hasArgument($name);
    }

    public function getOptions()
    {
        // TODO: Implement getOptions() method.
        return $this->input->getOptions();
    }

    public function setOption($name, $value)
    {
        // TODO: Implement setOption() method.
        $this->input->setOption($name, $value);
    }

    public function hasOption($name)
    {
        // TODO: Implement hasOption() method.
        return $this->input->hasOption($name);
    }

    public function isInteractive()
    {
        // TODO: Implement isInteractive() method.
        return $this->input->isInteractive();
    }

    public function setInteractive($interactive)
    {
        // TODO: Implement setInteractive() method.
        $this->input->setInteractive($interactive);
    }
}
